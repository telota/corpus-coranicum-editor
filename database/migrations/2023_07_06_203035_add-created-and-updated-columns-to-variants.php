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
        $tables = [
            "lc_leseart",
            "lc_leseart_leser",
            "lc_leseart_quelle",
            "lc_leser",
            "lc_quelle",
            "lc_quelle_leser",
            "lc_variante",
        ];

        foreach ($tables as $t) {
            Schema::table($t, function (Blueprint $table) {
                $table->string('created_by')->nullable();
                $table->string('updated_by')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->useCurrent();
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
