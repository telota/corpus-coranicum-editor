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
        Schema::create('kommentar_belegstelle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sure');
            $table->foreign('sure')->references('sure')->on('kommentar');
            $table->integer('belegstelle_id');
            $table->foreign('belegstelle_id')->references('ID')->on('belegstellen');
            $table->string('created_by');
            $table->string('updated_by');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('kommentar_belegstelle');
    }
};
