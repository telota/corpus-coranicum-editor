<?php

namespace App\Console\Commands\OneTimeFixes;

use App\Http\Controllers\ManuscriptPageImageController;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateManuscriptImageFilesToUuidFolders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:migrate-manuscript-image-files-to-uuid-folders {count}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function isCurrentFileSchema($image)
    {

        if (!isset($image->image_link)) {
            return false;
        }

        $path = $image->image_link;

        $segments = explode("/", $path);
        if (sizeof($segments) > 1 && Str::isUuid($segments[count($segments) - 2])) {
            return true;
        }

        return false;

    }

    private function findFile($images)
    {
        foreach ($images as $i) {
            if (Storage::disk("digilib")->exists($i->image_link)) {
                return $i->image_link;
            }

        }
        return null;
    }

    /**
     * Execute the console command.
     */
    public
    function handle()
    {

        $user = User::where('name', 'DATA_MIGRATION')->first();
        Auth::login($user);

        $imagesCountToMigrate = $this->argument("count");

        $images = ManuscriptPageImage::with(["page" => function ($query) {
            $query->select("id", "manuscript_id");
        }])->get();

        $imagesToMigrate = [];
        foreach ($images as $image) {
            if (sizeof($imagesToMigrate) >= $imagesCountToMigrate) {
                break;
            }

            if ($this->isCurrentFileSchema($image) == false && isset($image->image_link)) {
                $imagesToMigrate[] = $image;
            }
        }


        foreach ($imagesToMigrate as $i) {
            Log::info("Found image to migrate: {$i->image_link}.");
            $this->info("Found image to migrate: {$i->image_link}.");

            $extension = substr($i->image_link, strrpos($i->image_link, ".") + 1);


            $newLocation = ManuscriptPageImageController::createImageLocation(
                $image->page->manuscript_id,
                $image->page->id,
                $image->id,
                $extension
            );

            Log::info("The new image location will be $newLocation ");

            if (env("APP_ENV") !== "prod") {
                return;
            }

            if (Storage::disk("digilib")->exists($i->image_link)) {
                $this->info("Migrating " . $i->image_link . ".");
                Log::info("Migrating " . $i->image_link . " to " . $newLocation . ".");
                Storage::disk("digilib")->move($i->image_link, $newLocation);
                Log::info('Move successful. Saving new location to the database');
                $i->image_link = $newLocation;
                $i->save();
            } elseif (isset($i->prior_image_link) && Storage::disk("silo10")->exists($i->prior_image_link)) {
                Log::info("Found file {$i->prior_image_link} on silo10. Migrating from Silo.");
                //First create the file to prevent a copy error later
                Storage::disk("digilib")->put($newLocation, "");
                $source = Storage::disk("silo10")->path($i->prior_image_link);
                $destination = Storage::disk("digilib")->path($newLocation);
                if( !copy($source, $destination) ) {
                    Log::warning("File $source could not be copied to $destination");
                }

                Log::info('Move successful. Saving new location to the database');
                $i->image_link = $newLocation;
                $i->save();
            } else {

                Log::info("Checking for duplicates");
                $duplicates = ManuscriptPageImage::with(["page" => function ($query) use ($i) {
                    $query->select("id", "manuscript_id")->where("manuscript_id", "=", $i->page->manuscript_id);
                }])->where("original_filename", $i->original_filename)->get();

                if (sizeof($duplicates) > 1) {

                    Log::info("Found duplicates for {$i->original_filename}.");
                    $file = $this->findFile($duplicates);
                    if (isset($file)) {
                        Log::info("We can copy the following file as it seems to contain the same original file: $file");
                        Storage::disk("digilib")->copy($file, $newLocation);
                        Log::info('Move successful. Saving new location to the database');
                        $i->image_link = $newLocation;
                        $i->save();
                        continue;
                    }

                }

                Log::warning("Image {$i->image_link} not found. Cannot migrate to $newLocation.");

                $this->warn("Image {$i->image_link} not found. Skipping...");
            }

        }

    }
}
