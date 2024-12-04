<?php

use App\Http\Controllers\ManuscriptPageImageController;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    private $migrated_images = [];

    private function moveImagePath($oldFileLink, $page_id, $manuscript_id): string|null
    {

        if (array_key_exists($oldFileLink, $this->migrated_images)) {
            Log::info("File already exists for {$oldFileLink}.");
            return $this->migrated_images[$oldFileLink];
        }


        $pathinfo = pathinfo($oldFileLink);
        $extension = $pathinfo['extension'] ?? "";
        $path = ManuscriptPageImageController::createImagePath($manuscript_id, $page_id);
        $filename = ManuscriptPageImageController::createImageName($manuscript_id, $page_id, $extension);
        $newfile = $path . $filename;
        Log::info("Make new filename $newfile for $oldFileLink.");


        $this->migrated_images[$oldFileLink] = $newfile;
        return $newfile;
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $images = ManuskriptseitenBild::with(['seite', 'seite.manuskript'])->get();

        foreach ($images as $image) {

            if ($image->seite && $image->seite->manuskript) {

                $manuscript_id = $image->seite->manuskript->ID;
                $page_id = $image->seite->SeitenID;

                $newFile = $this->moveImagePath($image->Bildlink, $page_id, $manuscript_id);

                if ($newFile) {
                    $image->new_image_link = $newFile;
                    $image->save();
                }

            } else {
                $link = $image->Bildlink;
                $page_id = $image->seite ? $image->seite->SeitenID : null;
                Log::info("Problem with {$link}. No manuscript for image id {$image->id} and page id {$page_id}");
            }


        }


        $images_new = ManuscriptPageImage::with(['page', 'page.manuscript'])->get();
        foreach ($images_new as $image) {
            $manuscript_id = $image->page->manuscript->id;
            $page_id = $image->page->id;

            $newFile = $this->moveImagePath($image->image_link, $page_id, $manuscript_id);

            if ($newFile) {
                $image->new_image_link = $newFile;
                $image->save();
            }

        }

        //
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
