<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\Attribution;

class CreateMsAttributedToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_attributed_to', function (Blueprint $table) {
            $table->increments('id');
            $table->string("person")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_attributed_to` COMMENT 'It represents the people whom manuscripts attributed.'");

        // add initial data

        $msAttributedToData =
            [
                'Caliph ʿUṯmān b. ʿAffān', 'ʿAlī b. Abī Ṭālib',
                'Imām Riḍāʾ', 'Imām Ḥusain',
                'Imām as-Saǧǧād', 'Imām Ḥasan'
            ];

        foreach ($msAttributedToData as $datum) {
            $person = new Attribution();
            $person->person = $datum;
            $person->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_attributed_to');
    }
}
