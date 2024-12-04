<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lc_leseart_leser', function (Blueprint $table) {
            $table->foreign('leser')->references('id')->on('lc_leser');
            $table->foreign('leseart')->references('id')->on('lc_leseart');
            $table->unique(['leseart', 'leser']);
        });
        Schema::table('lc_leseart_quelle', function (Blueprint $table) {
            $table->foreign('quelle')->references('id')->on('lc_quelle');
            $table->foreign('leseart')->references('id')->on('lc_leseart');
            $table->unique('leseart');
        });
        Schema::table('lc_variante', function (Blueprint $table) {
            $table->foreign('leseart')->references('id')->on('lc_leseart');
            $table->unique(['leseart', 'wort']);
        });
        Schema::table('lc_leseart', function (Blueprint $table) {
            $table->after('vers', function (Blueprint $table) {
                $table->unsignedInteger('quelle_id')->nullable();
            });
            $table->foreign('quelle_id')->references('id')->on('lc_quelle');
        });
        
        Schema::create('lc_quelle_leser', function (Blueprint $table){
            $table->increments('id');
            $table->unsignedInteger('quelle_id');
            $table->foreign('quelle_id')->references('id')->on('lc_quelle');
            $table->unsignedInteger('leser_id');
            $table->foreign('leser_id')->references('id')->on('lc_leser');
            $table->unique(['quelle_id','leser_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
