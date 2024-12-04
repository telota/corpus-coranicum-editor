<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\ScriptStyle;

class CreateMsScriptStylesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_script_styles', function (Blueprint $table) {
            $table->increments('id');
            $table->string("style")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_script_styles` COMMENT 'It represents the script styles of manuscripts, according to Deroche.'");

        // add initial data

        $msScriptStylesData =
            [
                'ḥiǧāzī', 'ḥiǧāzī I', 'ḥiǧāzī II', 'ḥiǧāzī III', 'ḥiǧāzī IV',
                'kūfī', 'kūfī A I', 'kūfī B I a', 'kūfī B I b', 'kūfī B II', 'kūfī C I a',
                'kūfī C I b', 'kūfī C II', 'kūfī C III', 'kūfī D',
                'kūfī D I', 'kūfī D III', 'kūfī D IV', 'kūfī D V a',
                'kūfī D V b', 'kūfī D V c', 'kūfī D I / D III', 'kūfī Group D',
                'kūfī D common', 'kūfī E I', 'kūfī F I',
                'umayyad O', 'umayyad O I a', 'umayyad O I b',
                'new style', 'new style I', 'new style II', 'new style III',
                'maġribī', 'nasḫ', 'ṯuluṯ', 'muḥaqqaq', 'sūdānī', 'tauqīʿ',
                'taliq', 'nastaliq', 'raiḥānī', 'biḥārī', 'other (non classified)'
            ];

        foreach ($msScriptStylesData as $datum) {
            $style = new ScriptStyle();
            $style->style = $datum;
            $style->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_script_styles');
    }
}
