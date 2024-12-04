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
        if (Schema::hasColumn('ms_manuscript_mapping', 'word_start')) {
            Schema::table('ms_manuscript_mapping', function (Blueprint $table) {
                $table->dropColumn('word_start');
            });
        }
        if (Schema::hasColumn('ms_manuscript_mapping', 'word_end')) {
            Schema::table('ms_manuscript_mapping', function (Blueprint $table) {
                $table->dropColumn('word_end');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
