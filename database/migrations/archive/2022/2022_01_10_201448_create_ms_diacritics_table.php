<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\Diacritic;

class CreateMsDiacriticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_diacritics', function (Blueprint $table) {
            $table->increments('id');
            $table->string("diacritic")->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_diacritics` COMMENT 'It represents the diacritics of manuscripts.'");

        // add initial data

        $msDiacriticsData =
            [
                'ʾalif one dot', 'ʾalif two dots', 'bāʾ', 'tāʾ', 'ṯāʾ', 'ǧīm',
                'ḥāʾ', 'ḫāʾ', 'dāl', 'ḏāl', 'rāʾ', 'zāy', 'sīn', 'šīn', 'ṣād',
                'ḍād', 'ṭāʾ', 'ẓāʾ', 'ʿain', 'ġain', 'fāʾ dot above', 'fāʾ dot below',
                'qāf dot above', 'qāf dot below', 'qāf two dots above', 'kāf',
                'lām', 'mīm', 'nūn', 'hāʾ', 'wāw', 'yāʾ'
            ];

        foreach ($msDiacriticsData as $datum) {
            $diacritic = new Diacritic();
            $diacritic->diacritic = $datum;
            $diacritic->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_diacritics');
    }
}
