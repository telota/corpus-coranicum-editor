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
        Schema::create('lc_quelle_author_roles', function(Blueprint $table){
            $table->increments('id');
            $table->integer('quelle_id')->unsigned();
            $table->foreign("quelle_id")->references("id")->on("lc_quelle");
            $table->integer('author_role_id')->unsigned();
            $table->foreign('author_role_id')->references('id')->on('cc_author_roles');
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
        //
    }
};
