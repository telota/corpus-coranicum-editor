<?php

namespace App\Console\Commands\Importers;

use App\Models\GeneralCC\CCAuthorRole;
use App\Models\Manuscripts\Funder;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\Manuscripts\Place;
use App\Models\Manuscripts\ScriptStyle;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Matrix\Builder;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class ImportSanaaManuscripts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:sanaa-manuscripts {directory}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports Sanaa Manuscripts from an Excel file.';

    private function addAuthors($manuscript, $metadata, $image, $assistance)
    {
        $ids = [];

        $authors = [
            'metadata' => $metadata . "; Michael Marx",
            'image' => $image,
            'assistance' => $assistance,

        ];
        foreach ($authors as $key => $value) {

            if (!isset($value)) {
                continue;
            }
            $names = array_map('trim', explode(';', $value));
            foreach ($names as $name) {
                $author_role = CCAuthorRole::whereRelation('author', 'author_name', $name)
                    ->whereRelation('role', 'role_name', $key)
                    ->whereRelation('role.module', 'module_name', 'manuscript')
                    ->first();

                if ($author_role == null) {
                    Log::alert("No author role found for $name and $value");
                } else {
                    $ids[] = $author_role->id;
                }
                $manuscript->authors()->sync($ids);
            }
        }

    }

    private function makeManuscript($row, $sanaa_id)
    {
        Log::info("Making manuscript {$row['call_number']}");
        $m = new ManuscriptNew();
        $m->call_number = $row['call_number'];
        $m->place_id = $sanaa_id;
        $m->is_online = 1;
        $m->no_images = 0;
        if (isset($row['dimensions_width']) && isset($row['dimensions_height'])) {
            $m->dimensions = "{$row['dimensions_width']} x {$row['dimensions_height']}";
        }
        if (isset($row['format_text_field_width']) && isset($row['format_text_field_height'])) {
            $m->format_text_field = "{$row['format_text_field_width']} x {$row['format_text_field_height']}";
        }
        if (isset($row['line_count_min']) && isset($row['line_count_max'])) {
            $m->number_of_lines = "{$row['line_count_min']} - {$row['line_count_max']}";
        }
        $m->number_of_folios = $row['folio_count'];
        $m->date_start = $row['date_start'];
        $m->date_end = $row['date_end'];
        $m->writing_surface = $row['writing_surface'];
        $m->credit_line_image = $row['credit_line_image'];
        $m->codicology = $row['codicology'];
        $m->paleography = $row['paleography'];
        $m->ornaments = $row['ornaments'];

        $m->save();

        $this->addAuthors($m, $row['author'], $row['image_treatment'], $row['assistance']);

        //Funder
        if (Str::contains($row['funder'], "NEUSTART KULTUR")) {
            $funder = Funder::where('funder', "=", "Neustart Kultur")->first();
            $m->funders()->sync([$funder->id]);
        }
        //Scriptstyle
        if (isset($row['script_styles'])) {
            $script = ScriptStyle::where('style', 'like', '%' . Str::substr($row['script_styles'], 1))->first();
            if ($script == null) {
                Log::alert("No script found for " . $row['script_styles']);
            } else {
                $m->scriptStyles()->attach($script->id);
            }

        }

        return $m;
    }


    private function getJsonData($file_name)
    {
        $json = file_get_contents($this->argument('directory') . "/$file_name");

        return json_decode($json,true);

    }

    private function makeManuscripts()
    {
        $rows = $this->getJsonData('metadata.json');

        $sanaa = Place::where('place', '=', 'Sanaa')
            ->where('place_name', 'LIKE', '%Dār al-Maḫṭūṭāt%')
            ->firstOrFail();

        foreach ($rows as $m) {

            $existing = ManuscriptNew::where('place_id', $sanaa->id)
                ->where('call_number', $m['call_number'])
                ->first();

            if (isset($existing)) {
                if (new \DateTime($existing->created_at) < new \DateTime('2023-07-18')) {
                    Log::info("Taking old sanaa manuscript {$existing->call_number} offline");
                    $existing->call_number = $existing->call_number . " - alt";
                    $existing->is_online = 0;
                    $existing->save();
                    $this->makeManuscript($m, $sanaa->id);

                } else {
                    Log::info("Manuscript {$existing->call_number} already exists...skipping");
                }
            } else {
                $this->makeManuscript($m, $sanaa->id);
            }
        };
    }

    private function getNewishManuscript($call_number)
    {
        $m = ManuscriptNew::whereRelation('place', 'place', "=", "Sanaa")
            ->where('call_number', 'DAM ' . $call_number)->first();

        if (!isset($m)) {
            Log::info("No manuscript found with call number {$call_number}");
            return null;
        }
        $minutes_ago = new \DateTime("15 minutes ago");

        if ($m->created_at < $minutes_ago) {
            Log::info("Not appending pages or images to manuscript $call_number. It is more than 15 minutes old.");
            return null;
        }
        return $m;

    }


    private function makePage($manuscript_id, $folio, $page_side)
    {
        $page = new ManuscriptPage();
        $page->manuscript_id = $manuscript_id;
        $page->folio = $folio;
        $page->page_side = $page_side;
        $page->is_online = 1;
        $page->save();
        return $page;

    }

    private function makePagesFromPassageList()
    {
        Log::info("Making pages and passages for Sanaa Import");
        $rows = $this->getJsonData('passages.json');
        foreach ($rows as $row) {
            $m = $this->getNewishManuscript($row['manuscript']);
            if ($m == null) {
                continue;
            }

            $folio = $row['folio'];
            $page_side = $row['page_side'];

            $page = ManuscriptPage::where('manuscript_id', $m->id)
                ->where('folio', $folio)
                ->where('page_side', $page_side)
                ->first();

            if (isset($page)) {
                Log::info("Page already exists for {$m->call_number}, Page $folio $page_side. Skipping...");
            } else {
                Log::info("Creating the page {$row['manuscript']}, $folio $page_side");
                $page = $this->makePage($m->id, $folio, $page_side);

            }


            $existing_passage = ManuscriptPageMapping::where('manuscript_page_id', $page->id)
                ->where('sura_start', $row['sura_start'])
                ->where('verse_start', $row['verse_start'])
                ->where('word_start', $row['word_start'])
                ->where('sura_end', $row['sura_end'])
                ->where('verse_end', $row['verse_end'])
                ->where('word_end', $row['word_end'])
                ->first();

            if (isset($existing_passage)) {
                Log::info("Passage already exists for {$page->id}. Skipping...");
                continue;
            }

            $passage = new ManuscriptPageMapping();
            $passage->sura_start = $row['sura_start'];
            $passage->verse_start = $row['verse_start'];
            $passage->word_start = $row['word_start'];
            $passage->sura_end = $row['sura_end'];
            $passage->verse_end = $row['verse_end'];
            $passage->word_end = $row['word_end'];
            $passage->manuscript_page_id = $page->id;
            $passage->save();

        }

    }

    private function makeImages()
    {
        Log::info("Making images for Sanaa Import");
        $rows = $this->getJsonData('images.json');
        foreach ($rows as $row) {
            $call_number = $row['manuscript'];
            $folio = $row['folio'];
            $page_side = $row['page_side'];
            $sort = $row['sort'] + 1;

            $m = $this->getNewishManuscript($call_number);
            if ($m == null) {
                continue;
            }


            $page = ManuscriptPage::where('manuscript_id', $m->id)
                ->where('folio', $folio)
                ->where('page_side', $page_side)
                ->first();

            if (!isset($page)) {
                Log::alert("Creating new page $call_number, $folio $page_side. It wasn't added in the passages.");
                $page = $this->makePage($m->id,$folio, $page_side);
            }

            $existing = ManuscriptPageImage::where('manuscript_page_id', $page->id)
                ->where('sort', $sort)
                ->first();

            if (isset($existing)) {
                Log::info("Page aready exists for {$m->call_number}, $folio $page_side, sort $sort. Skipping...");
                continue;
            }

            Log::info("Creating image $sort for page $call_number, $folio $page_side");

            $image = new ManuscriptPageImage();
            $image->private_use_only = false;
            $image->manuscript_page_id = $page->id;
            $image->sort = $sort;
            $image->iiif_external = $row['iiif'];
            $image->thumbnail_external = $row['thumbnail'];
            $image->image_link_external = $row['external_link'];
            $image->original_filename = "";
            $image->credit_line_image = $m->credit_line_image;
            $image->save();
        }

    }

    public function handle()
    {

        $user = \App\Models\User::where('name', 'Marcus Lampert')->first();
        Auth::login($user);

        $this->makeManuscripts();

        $this->makePagesFromPassageList();

        $this->makeImages();
    }
}
