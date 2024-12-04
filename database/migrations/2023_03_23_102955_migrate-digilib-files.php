<?php

use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuskripte\ManuskriptseitenBild;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {

    private static function copyFile($old, $new): bool
    {
        if (env('APP_ENV') != "prod") {
            Log::info("Only moving files on prod");
            return false;
        }

        if (Storage::disk('silo10')->exists($new)) {
            Log::info("File already exists: $new. Skipping..");
            return true;
        }

        if (!isset($old)) {
            Log::info("File doesn't exist: $old. Skipping..");
            return false;
        }

        if (!Storage::disk('silo10')->exists($old)) {
            if (Storage::disk('silo10')->exists($old . ".tif")) {
                $old = $old . ".tif";
            }else{
                Log::info("File doesn't exist: $old. Skipping..");
                return false;
            }
        }


        Storage::disk('silo10')->copy($old, $new);
        return true;

    }

    public static function moveImage($image, $image_field)
    {
        $image_is_copied = false;
        if (isset($image->new_image_link) && strlen($image->new_image_link) > 0) {
            $image_is_copied = self::copyFile($image->$image_field, $image->new_image_link);
        }
        if ($image_is_copied) {
            $image->prior_image_link = $image->$image_field;
            $image->$image_field = $image->new_image_link;
            $image->new_image_link = null;
            $image->save();
        }

    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $images = ManuskriptseitenBild::all();
        foreach ($images as $image) {
            self::moveImage($image, 'Bildlink');
        }

        $images = ManuscriptPageImage::all();
        foreach ($images as $image) {
            self::moveImage($image, 'image_link');
        }

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
