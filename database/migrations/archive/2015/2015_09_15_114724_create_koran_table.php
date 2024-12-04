<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateKoranTable
 */
class CreateKoranTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koran', function (Blueprint $table) {
            $table->integer('id', true);
            $table->text('koranstelle');
            $table->string('Bild', 25);
            $table->text('praefix');
            $table->integer('sure');
            $table->integer('vers');
            $table->string('surenname')->nullable();
            $table->text('kommentar');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('koran');
    }
}
