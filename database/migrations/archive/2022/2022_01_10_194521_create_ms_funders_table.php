<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\Funder;

class CreateMsFundersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_funders', function (Blueprint $table) {
            $table->increments('id');
            $table->string("funder")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_funders` COMMENT 'It represents the funders of the manuscript project.'");

        // add initial data

        $msFundersData =
            [
                'CC', 'Paleocoran', 'Irankoran', 'Qatarkoran'
            ];

        foreach ($msFundersData as $datum) {
            $funder = new Funder();
            $funder->funder = $datum;
            $funder->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_funders');
    }
}
