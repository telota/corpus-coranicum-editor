<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateQortbl2Table
 */
class CreateQortbl2Table extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qortbl2', function (Blueprint $table) {
            $table->bigInteger('location')->default(0)->unique('location');
            $table->integer('suraverse')->nullable()->index('suraverse');
            $table->integer("sure_cc")->nullable();
            $table->integer("vers_cc")->nullable();
            $table->integer("wort_cc")->nullable();
            $table->integer('word_num')->nullable();
            $table->integer('analyse')->nullable();
            $table->string('word', 25)->nullable()->index('word');
            $table->string('word_cc', 25)->nullable()->index('word_cc');
            $table->string('base', 20)->nullable()->index('base');
            $table->string('base_cc', 20)->nullable()->index('base_cc');
            $table->string('root', 20)->nullable()->index('root');
            $table->string('root_cc', 20)->nullable()->index('root_cc');
            $table->string('prefix1', 5)->nullable();
            $table->string('prefix1_part_of_speech', 20)->nullable();
            $table->string('prefix1_semantic', 20)->nullable();
            $table->string('prefix2', 5)->nullable();
            $table->string('prefix2_part_of_speech', 20)->nullable();
            $table->string('prefix2_semantic', 20)->nullable();
            $table->string('prefix3', 5)->nullable();
            $table->string('prefix3_part_of_speech', 20)->nullable();
            $table->string('prefix3_semantic', 20)->nullable();
            $table->string('part_of_speech', 20)->nullable()->index('part_of_speech');
            $table->string('subcategory', 20)->nullable();
            $table->string('semantic', 20)->nullable()->index('semantic');
            $table->string('semantic2', 20)->nullable();
            $table->string('pattern', 15)->nullable()->index('pattern');
            $table->string('aspect', 15)->nullable()->index('aspect');
            $table->string('actpass', 7)->nullable();
            $table->string('mortality', 15)->nullable();
            $table->string('mood', 10)->nullable();
            $table->string('prefix', 55)->nullable();
            $table->string('gender', 10)->nullable();
            $table->string('number', 9)->nullable();
            $table->string('casefld', 10)->nullable();
            $table->string('person', 4)->nullable();
            $table->char('dependent_pron', 1)->nullable();
            $table->string('dependent_person', 4)->nullable();
            $table->string('dependent_number', 9)->nullable();
            $table->string('dependent_gender', 10)->nullable();
            $table->string('definite', 10)->nullable();
            $table->string('diptotic', 12)->nullable();
            $table->string('full_analyse', 150)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qortbl2');
    }
}
