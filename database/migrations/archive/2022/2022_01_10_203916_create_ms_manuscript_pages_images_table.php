<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuskripte\ManuskriptseitenBild;
use \App\Models\Manuscripts\ManuscriptPageImage;

class CreateMsManuscriptPagesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_pages_images', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_page_id")->nullable()->unsigned();
            $table->foreign("manuscript_page_id")
                ->references("id")->on("ms_manuscript_pages")
                ->onDelete('cascade');
            $table->string("image_link",500)->nullable(); // bildlink
            $table->text("image_link_external", 2083)->nullable(); // bildlink_extern
            $table->text("credit_line_image", 2083)->nullable(); // bildlinknachweis
            $table->tinyInteger("is_online")->default('0');
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->index("is_online");
//            $table->unique(['manuscript_page_id', 'image_link'], "unique_index"); // too many duplicates in the old table manuskriptseiten_bilder to copy
        });

        DB::statement("ALTER TABLE `ms_manuscript_pages_images` COMMENT 'Old table: manuskriptseiten_bilder. It represents the digilib link to a certain manuscript page image.'");

        // transfer data from 'manuskriptseiten_bilder' to 'ms_manuscript_pages_images'

        foreach(ManuskriptseitenBild::all() as $image)
        {
            if(\App\Models\Manuscripts\ManuscriptPage::find($image->manuskriptseite)) {
                ManuscriptPageImage::create([
                    'manuscript_page_id' => $image->manuskriptseite,
                    'image_link' => $image->Bildlink,
                    'image_link_external' => $image->Bildlink_extern,
                    'credit_line_image' =>$image->Bildlinknachweis
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_pages_images');
    }
}
