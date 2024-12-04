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
        Schema::table('glossarium', function (Blueprint $table) {
            $table->renameColumn('ID','id');
        });

        Schema::rename('glossarium2', 'glossarbelege');

        Schema::table('glossarbelege', function (Blueprint $table) {
            $table->renameColumn('Gloss2ID','id');
            $table->renameColumn('Gloss1ID','glossarium_id');
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
