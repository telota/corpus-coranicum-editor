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
        foreach (['ms_manuscript_mapping', 'ms_manuscript_pages_mapping'] as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->decimal('sura_start', 3, 0)->nullable(false)->change();
                $table->decimal('verse_start', 3, 0)->nullable(false)->change();
                $table->decimal('sura_end', 3, 0)->nullable(false)->change();
                $table->decimal('verse_end', 3, 0)->nullable(false)->change();
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
