<?php

namespace App\Console\Commands\OneTimeFixes;

use Illuminate\Console\Command;

class FixImageLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:fix-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    private function fixLinks($table, $image_field)
    {
        $instance = new $table;
        $images = $instance::whereNotNull('new_image_link')->where($image_field, "LIKE", "Samarkand%")->get();

        foreach ($images as $image) {
            $this->info("Found {$image->$image_field}");

            if (substr($image->$image_field, -3) == 'jpg') {
                $newName = substr($image->$image_field, 0, -3) . "JPG";
                $this->info("Changing to $newName");
                $image->$image_field = $newName;
                $image->save();
            }
        }

        $images = $instance::whereNotNull('new_image_link')->get();

        foreach ($images as $image) {
            $pathinfo = pathinfo($image->new_image_link);
            if (!isset($pathinfo['extension'])) {
                $new_link = $image->new_image_link . ".tif";
                $this->info("Old link {$image->$image_field}");
                $this->info("Changing path to $new_link");
                $image->new_image_link = $new_link;
                $image->save();
            }
        }
        $image = $instance::findOrFail(12541);
        $image->$image_field = "St._Petersburg_E-20/05,10-17.jpg";
        $image->save();


        $image = $instance::where($image_field, "=", "Washington/folio 14reco.tif")->first();
        $image->$image_field = "Washington/folio 14recto.tif";
        $image->save();


        $images = $instance::whereNotNull('new_image_link')->where($image_field, "LIKE", "Gotha%")->get();
        foreach ($images as $image) {
            $newLink = substr($image->$image_field, 0, -3) . "jpg";
            $this->info("{$image->$image_field}");
            $image->$image_field = $newLink;
            $image->new_image_link = substr($image->new_image_link, 0, -3) . "jpg";
            $this->info("{$image->$image_field}");
            $image->save();
        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->fixLinks(
            "App\Models\Manuskripte\ManuskriptseitenBild",
            "Bildlink"
        );

        $this->fixLinks(
            "App\Models\Manuscripts\ManuscriptPageImage",
            "image_link"
        );

    }
}
