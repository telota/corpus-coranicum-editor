<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Class CreateUsersLegacyTable
 */
class CreateUsersLegacyTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_legacy', function (Blueprint $table) {
            $table->integer('ID', true);
            $table->text('Username');
            $table->text('Password');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_legacy');
    }
}
