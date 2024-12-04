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
        Schema::table('belegstellen', function(Blueprint $table){

            $table->string('Sprache',1000)->nullable()->change();
            $table->string('Ort',1000)->nullable()->change();
            $table->string('kategorie', 255)->nullable()->change();
        });
        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
