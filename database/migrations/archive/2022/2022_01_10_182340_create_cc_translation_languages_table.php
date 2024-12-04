<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\GeneralCC\TranslationLanguage;

class CreateCcTranslationLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_translation_languages', function (Blueprint $table) {
            $table->increments('id');
            $table->string("translation_language")->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `cc_translation_languages` COMMENT 'It represents the languages of translation texts.'");

        //   add initial value

        $ccTranslationLanguagesData =
            [
                'german', 'english', 'french',
                'arabic', 'latin', 'russian',
                'dutch', 'spanish', 'italian',
                'persian', 'hebrew', 'turkish',
                'bahasa'
            ];

        foreach ($ccTranslationLanguagesData as $datum) {
            $language = new TranslationLanguage();
            $language->translation_language = $datum;
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
        Schema::drop('cc_translation_languages');
    }
}
