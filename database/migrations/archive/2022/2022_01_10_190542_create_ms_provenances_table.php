<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\Provenance;

class CreateMsProvenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_provenances', function (Blueprint $table) {
            $table->increments('id');
            $table->string("provenance")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_provenances` COMMENT 'It represents the place of origin of manuscripts.'");

        // add initial data

        $msProvenancesData =
            [
                'Kūfa', 'Baṣra', 'Madīna', 'Makka',
                'Dimašq', 'al-Fusṭāṭ', 'Ḥims', 'Qairawān'
            ];

        foreach ($msProvenancesData as $datum) {
            $provenance = new Provenance();
            $provenance->provenance = $datum;
            $provenance->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_provenances');
    }
}
