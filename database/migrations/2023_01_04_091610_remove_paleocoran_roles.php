<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemovePaleocoranRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $roles = DB::table('roles')->where('name', 'paleocoran_role')
            ->orWhere('name', 'paleocoran_admin')->get();

        foreach ($roles as $role) {
            DB::table('role_user')->where('role_id', $role->id);
            DB::table('roles')->where('id', $role->id)->delete();
        }
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
