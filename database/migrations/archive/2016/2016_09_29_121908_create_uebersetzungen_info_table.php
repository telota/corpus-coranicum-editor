<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUebersetzungenInfoTable
 */
class CreateUebersetzungenInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uebersetzungen_info', function (Blueprint $table) {
            $table->string("label", 191);
            $table->primary("label");
            $table->string("info");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('uebersetzungen_info');
    }
}
