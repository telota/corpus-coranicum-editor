<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('ms_manuscript_mapping', 'word_start')) {
            Schema::table('ms_manuscript_mapping', function (Blueprint $table) {
                $table->after('verse_start', function (Blueprint $table) {
                    $table->decimal('word_start', 3, 0)->nullable();
                });
            });
        }
        if (!Schema::hasColumn('ms_manuscript_mapping', 'word_end')) {
            Schema::table('ms_manuscript_mapping', function (Blueprint $table) {
                $table->after('verse_end', function (Blueprint $table) {
                    $table->decimal('word_end', 3, 0)->nullable();
                });
            });
        }

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
