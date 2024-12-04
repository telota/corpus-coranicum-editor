<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('manuskript', function (Blueprint $table) {
            $table->renameColumn('AufbewahrungsortId','place_id');
        });

        Schema::table('manuskript', function (Blueprint $table) {
            $table->unsignedInteger('place_id')->nullable()->change();
        });

        $ms = \App\Models\Manuskripte\Manuskript::all();
        foreach ($ms as $m){
            if($m->place_id == 0){
                $m->place_id = null;
                $m->save();
            }
        }


        Schema::table('manuskript', function (Blueprint $table) {
            $table->foreign('place_id')->references('id')->on('ms_places');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
