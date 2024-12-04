<?php

namespace App\Console\Commands;

use App\Models\Manuscripts\ManuscriptPageImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FixEmptyFiles extends Command
{
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

    private function copyFromSilo($i)
    {
        if (isset($i->prior_image_link) && Storage::disk("silo10")->exists($i->prior_image_link)) {
            Log::info("Found file {$i->prior_image_link} on silo10. Migrating from Silo.");
            $source = Storage::disk("silo10")->path($i->prior_image_link);
            $destination = Storage::disk("digilib")->path($i->image_link);
            if (!copy($source, $destination)) {
                Log::warning("File $source could not be copied to $destination");
            }
            Log::info('Move successful. Saving new location to the database');
        }

    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-empty-files';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $images = ManuscriptPageImage::get();

        foreach ($images as $i) {

            if (isset($i->image_link) && Storage::disk("digilib")->exists($i->image_link)) {

                if (Storage::disk("digilib")->size($i->image_link) == 0) {
                    $this->info("Found empty file: {$i->image_link} allegedly copied from {$i->prior_image_link}");
                    Log::info("Found empty file: {$i->image_link} allegedly copied from {$i->prior_image_link}");
                    $this->copyFromSilo($i);
                }

            }


        }


        //
    }
}
