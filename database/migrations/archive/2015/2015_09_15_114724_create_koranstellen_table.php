<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateKoranstellenTable
 */
class CreateKoranstellenTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koranstellen', function (Blueprint $table) {
            $table->integer('belegstellenID')->default(0)->index('belegstellenID');
            $table->text('koranstelle');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('koranstellen');
    }
}
