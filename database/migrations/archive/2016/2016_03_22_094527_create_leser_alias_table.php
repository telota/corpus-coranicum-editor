<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLeserAliasTable
 */
class CreateLeserAliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lc_leser_alias', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("leser");
            $table->string("alias");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('lc_leser_alias');
    }
}
