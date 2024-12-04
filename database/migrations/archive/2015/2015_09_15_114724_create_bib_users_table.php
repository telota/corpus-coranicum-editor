<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateBibUsersTable
 */
class CreateBibUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bib_users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string('username', 15)->unique('name');
            $table->string('password', 15);
            $table->string('name', 60);
            $table->string('remote', 30);
            $table->string('permissions', 60);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bib_users');
    }
}
