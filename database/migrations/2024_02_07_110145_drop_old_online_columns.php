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
        if (Schema::hasColumn('ms_manuscript', 'is_online_old')) {
        Schema::table('ms_manuscript', function (Blueprint $table) {
                $table->dropColumn('is_online_old');
            });
        }
        if (Schema::hasColumn('ms_manuscript_pages_images', 'is_online')) {
            Schema::table('ms_manuscript_pages_images', function (Blueprint $table) {
                $table->dropColumn('is_online');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
