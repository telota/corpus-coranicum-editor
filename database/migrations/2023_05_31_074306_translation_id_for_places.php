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
        Schema::table('ms_places', function (Blueprint $table) {
            $table->after('description', function(Blueprint $table){
                $table->unsignedInteger('translation_id')->nullable();
            });

            $table->foreign('translation_id')->references('id')->on('translations');
        });

        $user = \App\Models\User::where('name','DATA_MIGRATION')->first();
        Auth::login($user);
        foreach (\App\Models\Manuscripts\Place::all() as $place){
            if(preg_match('/^[a-z_-]+$/', $place->description)){
                $translation = \App\Models\Translation::where("key",$place->description)->first();
                if(isset($translation)){
                    $place->description = null;
                    $place->translation_id = $translation->id;
                    $place->save();
                }

            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ms_places', function (Blueprint $table) {
            $table->dropForeign(['translation_id']);
            $table->dropColumn('translation_id');

        });
    }
};
