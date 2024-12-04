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
        Schema::table('kommentar', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->default('CURRENT_TIMESTAMP')
                ->nullable()
                ->change();
            $table->timestamp('updated_at')
                ->default('CURRENT_TIMESTAMP')
                ->nullable()
                ->change();


            $columns = [
                'xml',
                'textstruktur',
                'bibliography_anmerkung',
                'bibliography_kommentar',
                'bibliography_literarkritik',
                'bibliography_textkritik',
                'bibliography_entwicklungsgeschichte',
                'bibliography_inhaltstruktur',
                'bibliography_situativitaet',
            ];

            foreach ($columns as $c){
                $table->mediumText($c)->nullable()->change();
            }

            $table->after('sure', function (Blueprint $table) {
                $table->string('commentary_file', 100)->nullable();
                $table->string('text_structure_file', 100)->nullable();
            });

        });

        Schema::table('ms_manuscript', function (Blueprint $table) {
            $table->after('catalogue_entry', function (Blueprint $table) {
                $table->string('transliteration_file', 100)->nullable();
            });
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
