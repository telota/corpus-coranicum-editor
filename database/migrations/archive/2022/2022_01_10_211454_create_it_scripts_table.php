<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Intertexts\Script;

class CreateItScriptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_scripts', function (Blueprint $table) {
            $table->increments('id');
            $table->string("script")->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `it_scripts` COMMENT 'It represents the languages of intertext transcriptions.'");

        // add initial data

        $itScriptsData =
            [
                'Latin', 'Greek', 'Arabic', 'Ancient South Arabian',
                'Nabatean', 'Ancient North Arabian', 'Ethiopian',
                'Armenian', 'Georgian', 'Cyrillic', 'Hebrew'
            ];

        foreach ($itScriptsData as $datum) {
            $script = new Script();
            $script->script = $datum;
            $script->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_scripts');
    }
}
