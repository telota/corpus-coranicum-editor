<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Intertexts\OriginalLanguage;

class CreateItOriginalLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_original_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string("original_language")->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `it_original_languages` COMMENT 'It represents the languages of intertext original texts.'");

        // add initial data

        $itOriginalLanguagesData =
            [
                'Arabic', 'Sabaic', 'Aramaic', 'Hebrew', 'Greek', 'Aramaic/Arabic',
                'Minaic', 'Dedanic', 'Safaitic', 'Armenian', 'Georgian', 'Church Slavonic',
                'Aramaic/Hebrew', 'Latin', 'Old Spanish'
            ];

        foreach ($itOriginalLanguagesData as $datum) {
            $language = new OriginalLanguage();
            $language->original_language = $datum;
            $language->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_original_languages');
    }
}
