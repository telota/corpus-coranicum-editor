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
        Schema::table('kommentar', function (Blueprint $table) {
            $table->dropColumn('xml');
            $table->dropColumn('textstruktur');
        });

        Schema::table('manuskript', function (Blueprint $table) {
            $table->dropColumn('transliteration_alt');
        });

        Schema::table('ms_manuscript', function (Blueprint $table) {
            $table->dropColumn('transliteration');
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
