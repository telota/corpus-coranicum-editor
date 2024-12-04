<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateTranslationsTable
 */
class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string("key", 191)->unique();
            $table->text("de");
            $table->text("en");
            $table->text("fr");
            $table->text("ar");
            $table->text("fa");
            $table->text("ru");
            $table->text("tr");
            $table->integer("user_id")->unsigned();
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
