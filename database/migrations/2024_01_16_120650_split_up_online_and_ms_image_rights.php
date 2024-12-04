<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('ms_manuscript', function (Blueprint $table) {
            if (Schema::hasColumn('ms_manuscript', 'is_online_new')) {
                $table->dropColumn('is_online_new');
            }

            if (Schema::hasColumn('ms_manuscript', 'no_images')) {
                $table->dropColumn('no_images');
            }
        });

        Schema::table('ms_manuscript', function (Blueprint $table) {
            $table->after('is_online', function (Blueprint $table) {
                $table->boolean('is_online_new');
                $table->boolean("no_images");
            });
        });

        $user = User::where('name', 'DATA_MIGRATION')->first();
        Auth::login($user);

        $manuscripts = \App\Models\Manuscripts\ManuscriptNew::all();
        foreach ($manuscripts as $ms) {
            if ($ms->is_online == 2) {
                $ms->is_online_new = true;
                $ms->save();
            }elseif ($ms->is_online == 1){
                $ms->is_online_new = true;
                $ms->no_images = true;
                $ms->save();

            }
        }

        Schema::table('ms_manuscript', function (Blueprint $table) {
                $table->renameColumn('is_online', 'is_online_old');
                $table->renameColumn('is_online_new', 'is_online');
        });

    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_manuscript', function (Blueprint $table) {
            if (Schema::hasColumn('ms_manuscript', 'is_online_new')) {
                $table->dropColumn('is_online_new');
            }

            if (Schema::hasColumn('ms_manuscript', 'no_images')) {
                $table->dropColumn('no_images');
            }
        });
    }
};
