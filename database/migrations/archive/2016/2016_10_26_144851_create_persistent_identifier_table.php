<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreatePersistentIdentifierTable
 */
class CreatePersistentIdentifierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persistent_identifier', function (Blueprint $table) {

            // Increment
            $table->increments('id');

            // UUID (persistent identifier)
            $table->uuid("pid");

            // Reference to the original id
            $table->integer("original_id");

            // Reference to the original relation
            $table->string("original_relation");

            // Timestamps
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persistent_identifier');
    }
}
