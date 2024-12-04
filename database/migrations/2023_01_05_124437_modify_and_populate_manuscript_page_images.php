<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use App\Models\Manuscripts\ManuscriptPage;
use App\Models\Manuscripts\ManuscriptPageImage;
use App\Models\Manuskripte\ManuskriptseitenBild;

class ModifyAndPopulateManuscriptPageImages extends Migration
{
    private function migrateImages()
    {


        $oldImages = ManuskriptseitenBild::orderBy('id')->get();

        $lastOldId = $oldImages->last()->id;

        foreach ($oldImages as $old) {
            Log::info("Working on manuscript image {$old->id}");
            if (ManuscriptPage::find($old->manuskriptseite)) {
                $new = ManuscriptPageImage::create([
                    'created_by' => "DATA_MIGRATION",
                    'manuscript_page_id' => $old->manuskriptseite,
                    'original_filename' => $old->Bildlink,
                    'image_link' => $old->Bildlink,
                    'image_link_external' => $old->Bildlink_extern,
                    'credit_line_image' => $old->Bildlinknachweis,
                    'is_online' => $old->webtauglich == "ja",
                    'sort' => $old->sort,
                ]);
                $new->id = $old->id + $lastOldId;
                $new->save();
            } else {
                Log::info("No manuscript page with id {$old->manuskriptseite} found for imgage id {$old->id}.");
            }
        }

        foreach (ManuscriptPageImage::all() as $image) {
            $image->id = $image->id - $lastOldId;
            $image->updated_by = "DATA_MIGRATION";
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

        Log::info("Working on image migration");

        ManuscriptPageImage::truncate();

        Schema::table('ms_manuscript_pages_images', function ($table) {
            $table->boolean('is_online')->change();
            $table->string('original_filename');
        });

        DB::transaction(function () {
            $this->migrateImages();
        });

        $increment = ManuscriptPageImage::max('id') + 1;
        DB::statement("ALTER TABLE ms_manuscript_pages_images AUTO_INCREMENT =  {$increment}");
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
}
