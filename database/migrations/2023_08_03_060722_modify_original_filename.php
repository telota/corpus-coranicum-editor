<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement('ALTER TABLE ms_manuscript_pages_images CHANGE original_filename original_filename VARCHAR(255) AFTER image_link');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
