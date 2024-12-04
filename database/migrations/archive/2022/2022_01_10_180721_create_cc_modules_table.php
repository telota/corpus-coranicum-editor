<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\GeneralCC\Module;

class CreateCcModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_modules', function (Blueprint $table) {
            $table->increments('id');
            $table->string("module_name", 100)->unique();
            $table->text("module_description", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `cc_modules` COMMENT 'It represents and describes all modules in the Corpus Coranicum project.'");

        //   add initial data

        $ccModulesData =
            [
                'manuscript', 'intertext'
            ];

        foreach ($ccModulesData as $datum) {
            $module = new Module();
            $module->module_name = $datum;
            $module->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cc_modules');
    }
}
