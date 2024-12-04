<?php

namespace App\Console\Commands\Importers;

use App\Http\Controllers\ManuscriptPageImageController;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuscripts\ManuscriptPageMapping;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class ImportDigilibImagesPassages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:digilib-images-passages {--file=} {--folder=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function moveImageToManagedLocation($image){

        $this->info("Making new path for image.");

        $extension = substr($image->image_link, strrpos($image->image_link, ".") + 1);

        $newLocation = ManuscriptPageImageController::createImageLocation(
            $image->page->manuscript_id,
            $image->page->id,
            $image->id,
            $extension
        );

        $this->info("Migrating {$image->image_link} to $newLocation.");
        if(!Storage::disk("digilib")->exists($image->image_link)){
            $this->warn("Image does not exist! Cannot move it: {$image->image_link}");
        }
        Storage::disk("digilib")->copy($image->image_link, $newLocation);
        $image->image_link = $newLocation;
        $image->save();
    }

    private function updateSortValues($page_id, $newImageSortValue){

        $images = ManuscriptPageImage::where('manuscript_page_id', $page_id)->get();
        if(sizeof($images) > 0){
            $this->info("Found existing images. Updating sort values");
        }

        $max_sort = sizeof($images) + 1;

        if ($newImageSortValue < 1) {
            $sort = 1;
        } elseif ($newImageSortValue > $max_sort) {
            $sort = $max_sort;
        } else {
            $sort = $newImageSortValue;
        };

            ManuscriptPageImage::where('manuscript_page_id', $page_id)
                ->where('sort', '>=', $sort)
                ->orderByDesc('sort')
                ->update(['sort' => DB::raw('sort + 1')]);
    }
    /**
     * Execute the console command.
     */

    public function importFromJsonFile($filepath)
    {
        $this->info("Importing json now: $filepath.");

        $file = file_get_contents($filepath); //import json file as$ms_import_data
        $ms_import_data = json_decode($file, true);

        // check if all entries from the same manuscript, else Error
        $all_ids = [];
        foreach ($ms_import_data as $a) {
            $all_ids[] = $a['manuscript'];
        }
        if (count(array_unique($all_ids)) > 1) {
            throw new Exception("Contains more than one Manuscript ID.");
        }

        // check if manuscript exists, else Error
        $manuscript_id = $ms_import_data[0]['manuscript'];
        if (!(ManuscriptNew::find($manuscript_id)->exists())) {
            throw new Exception("Manuscript has not been created yet.");
        }

        $manuscript = ManuscriptNew::find($manuscript_id);

        $user = User::where('name', 'DATA_MIGRATION')->first();
        Auth::login($user);


        // loop through manuscript pages in array
        foreach ($ms_import_data as $a) {
            $folio = $a['folio'];
            $page_side = $a['page_side'];
            $sura_start = $a['start_sura'];
            $verse_start = $a['start_verse'];
            $word_start = $a['start_word'];
            $sura_end = $a['end_sura'];
            $verse_end = $a['end_verse'];
            $word_end = $a['end_word'];
            $sort = 1;
            $img_digilib_url_array = explode('corpus-coranicum/',$a['image_url']);
            $img_digilib_url = end($img_digilib_url_array);
            $img_original_filename_array = explode('/',$img_digilib_url);
            $img_original_filename = end($img_original_filename_array);

            // check if folio - page_side exists for manuscript_id, else create
            $manuscript_page = ManuscriptPage::where('manuscript_id', $manuscript->id)
                ->where('folio', $folio)
                ->where('page_side', $page_side)
                ->first();
            
            if (!isset($manuscript_page)) {
                $this->info("Creating new page $folio $page_side for manuscript id $manuscript_id.");
                $manuscript_page = new ManuscriptPage();
                $manuscript_page->manuscript_id = $manuscript_id;
                $manuscript_page->folio = $folio;
                $manuscript_page->page_side = $page_side;
                $manuscript_page->is_online = 1;
                $manuscript_page->save();
            }

            // check if mapping already exists for manuscript_page or if sura or verse null, else create
            $existing_passage = ManuscriptPageMapping::where('manuscript_page_id', $manuscript_page->id)
            ->where('sura_start', $sura_start)
            ->where('verse_start', $verse_start)
            ->where('word_start', $word_start)
            ->where('sura_end', $sura_end)
            ->where('verse_end', $verse_end)
            ->where('word_end', $word_end)
            ->first();

            if (!isset($existing_passage) and !in_array(null,[$a['start_sura'],$a['start_verse'], $a['end_sura'], $a['end_verse']])) {
                    $this->info("Creating new passage for page $folio $page_side.");
                    $passage = new ManuscriptPageMapping();
                    $passage->sura_start = $a['start_sura'];
                    $passage->verse_start = $a['start_verse'];
                    $passage->word_start = $a['start_word'];
                    $passage->sura_end = $a['end_sura'];
                    $passage->verse_end = $a['end_verse'];
                    $passage->word_end = $a['end_word'];
                    $passage->manuscript_page_id = $manuscript_page->id;
                    $passage->save();    
                }
                $this->updateSortValues($manuscript_page->id, $sort);

            //Create new manuscript image (if there are no images for this page yet)
            $existing_image = ManuscriptPageImage::where('manuscript_page_id', $manuscript_page->id)
            ->where('image_link', $img_digilib_url)
            ->first();

            if (!isset($existing_image)) {
                $this->info("Creating new image $img_digilib_url for page $folio $page_side.");
                $image = new ManuscriptPageImage();
                $image->manuscript_page_id = $manuscript_page->id;
                $image->sort = $sort;
                $image->image_link = $img_digilib_url;
                $image->original_filename = $img_original_filename;
                $image->private_use_only = true;
                $image->save();
    
                $this->info("Image $img_digilib_url saved to database.");
    
                if(env("APP_ENV") == "prod"){
                    $this->moveImageToManagedLocation($image);
                }
            }
            }

            
        }
        
    public function handle(){
        $file = $this->option('file');
        $folder = $this->option('folder');

        if(isset($file)){
            $this->importFromJsonFile($file);
        }

        if(isset($folder)){
            $files = array_diff(scandir($folder), array('.', '..'));
            foreach($files as $f){
                $this->importFromJsonFile($folder . "/" . $f);
            }
        }

    }
}
