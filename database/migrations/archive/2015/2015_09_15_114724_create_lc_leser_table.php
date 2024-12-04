<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcLeserTable
 */
class CreateLcLeserTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leser', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->string('anzeigename');
            $table->string('sigle', 10)->default('')->unique('sigle');
            $table->text('abkuerzung');
            $table->text('kommentar')->nullable();
            $table->text('ort');
            $table->text('biografie');
            $table->text('namekomplett');
            $table->text('todesdatum');
            $table->text('todesdatum_AH');
            $table->string('ueberlieferer', 250)->default('');
            $table->text('ueberlieferertyp');
            $table->boolean('kanonisch')->default(0);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_leser');
    }
}
