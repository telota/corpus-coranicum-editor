<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateLcVarianteTable
 */
class CreateLcVarianteTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_variante', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('leseart')->default(0);
            $table->integer('wort')->default(0);
            $table->string('variante')->default('');
            $table->integer('alt_sure')->nullable();
            $table->integer('alt_vers')->nullable();
            $table->integer('alt_wort')->nullable();
            $table->unique(['leseart','wort'], 'lesart_worte');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_variante');
    }
}
