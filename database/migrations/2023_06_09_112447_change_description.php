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
        Schema::table('ms_places', function (Blueprint $table) {
            $table->dropColumn('description');
        });

        Schema::table('ms_places', function (Blueprint $table) {
            $table->renameColumn('translation_id','description_id');
        });

        Schema::drop('aufbewahrungsorte');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
