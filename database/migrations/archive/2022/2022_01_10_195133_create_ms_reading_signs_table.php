<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\ReadingSign;

class CreateMsReadingSignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_reading_signs', function (Blueprint $table) {
            $table->increments('id');
            $table->string("reading_sign")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_reading_signs` COMMENT 'It represents the reading signs or vowel signs a manuscript can have.'");

        // add initial data

        $msReadingSignsData =
            [
                'red dots', 'green dots', 'blue dots', 'yellow dots',
                'red stroke', 'green stroke', 'blue stroke', 'yellow stroke', 'no sign'
            ];

        foreach ($msReadingSignsData as $datum) {
            $readingSign = new ReadingSign();
            $readingSign->reading_sign = $datum;
            $readingSign->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_reading_signs');
    }
}
