<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcQuelleTable
 */
class CreateLcQuelleTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_quelle', function (Blueprint $table) {
            $table->increments('id');
            $table->string('abkuerzung', 20)->default('')->unique('abkuerzung');
            $table->string('quelle_arabisch', 200);
            $table->string('autor_arabisch', 100);
            $table->string('anzeigetitel')->nullable();
            $table->text('autor_langfassung');
            $table->text('beschreibung');
            $table->text('todesdatum');
            $table->text('todesdatum_ah')->nullable();
            $table->text('ort');
            $table->text('referenz');
            $table->boolean('kanonisch')->default(0);
            $table->string('datum')->nullable();
            $table->integer('sort')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_quelle');
    }
}
