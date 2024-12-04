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
        Schema::table('lc_quelle', function(Blueprint $table){

            $table->string('anzeigetitel',255)->nullable(false)->change();
            $table->string('datum',255)->nullable()->change();
            $table->text('beschreibung')->nullable()->change();
            $table->text('referenz')->nullable()->change();
            $table->text('ort')->nullable()->change();
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
