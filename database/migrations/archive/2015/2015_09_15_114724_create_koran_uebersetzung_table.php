<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateKoranUebersetzungTable
 */
class CreateKoranUebersetzungTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('koran_uebersetzung', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('sprache', 2);
            $table->string('sure_vers', 20);
            $table->text('text');
            $table->integer('sure')->nullable();
            $table->integer('vers')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('koran_uebersetzung');
    }
}
