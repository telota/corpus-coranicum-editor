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
        Schema::table('ms_manuscript_pages_images', function (Blueprint $table) {
            $table->after('image_link', function (Blueprint $table) {
                $table->string('iiif_external', 250)->nullable();
                $table->string('thumbnail_external', 250)->nullable();
            });
        });
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
