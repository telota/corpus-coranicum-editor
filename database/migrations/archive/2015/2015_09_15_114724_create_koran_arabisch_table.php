<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateKoranArabischTable
 */
class CreateKoranArabischTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koran_arabisch', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('Ort', 15);
            $table->text('Text');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('koran_arabisch');
    }
}
