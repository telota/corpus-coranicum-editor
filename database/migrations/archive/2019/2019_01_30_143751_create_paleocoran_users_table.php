<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaleocoranUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paleocoran_users', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer("codex")->references("id")->on("paleocoran_manuscript_codex");
            $table->integer("user")->references("id")->on("users");
            $table->string("module", 191);
            $table->unique(["codex", "user", "module"]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
