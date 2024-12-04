<?php

namespace App\Console\Commands\Importers;

use App\Http\Controllers\ManuscriptPageImageController;
use App\Models\Manuscripts\ManuscriptNew;
use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;

class ImportManuscriptImagesFromNebula extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:manuscript-images-from-nebula {--file=} {--folder=}';

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

        $file = file_get_contents($filepath); //import json file as array
        $array = json_decode($file, true);

        //check if all entries from the same manuscript, else: Error
        $all_ids = [];
        foreach ($array as $a) {
            $all_ids[] = $a['manuscript'];
        }
        if (count(array_unique($all_ids)) > 1) {
            throw new Exception("Contains more than one Manuscript ID.");
        }

        //check if manuscript exists, else Error
        $manuscript_id = $array[0]['manuscript'];
        if (!(ManuscriptNew::find($manuscript_id)->exists())) {
            throw new Exception("Manuscript has not been created yet.");
        }

        $manuscript = ManuscriptNew::find($manuscript_id);

        $user = User::where('name', 'DATA_MIGRATION')->first();
        Auth::login($user);


        // for all entries:
        foreach ($array as $a) {
            $folio = $a['folio'];
            $page_side = $a['page_side'];
            $sort = $a['sort'];
            $image_path = $a['image'];
            $image_credit = $a['image_credit'];

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

            $this->updateSortValues($manuscript_page->id, $sort);

            // Create new manuscript image
            $this->info("Creating new image $image_path for page $folio $page_side.");
            $image = new ManuscriptPageImage();
            $image->manuscript_page_id = $manuscript_page->id;
            $image->sort = $sort;
            $image->image_link = '_import/' . $image_path;
            $image->original_filename = $image_path;
            $image->credit_line_image = $image_credit;
            $image->private_use_only = true;
            $image->save();

            $this->info("Image $image_path saved to database.");

            if(env("APP_ENV") == "prod"){
                $this->moveImageToManagedLocation($image);
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
