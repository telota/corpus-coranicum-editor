<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        Schema::table('ms_manuscript_pages', function (Blueprint $table) {
            $table->after('is_online', function (Blueprint $table) {
                $table->boolean('is_online_new');
            });
        });


        $user = User::where('name', 'DATA_MIGRATION')->first();
        Auth::login($user);

        $pages = \App\Models\Manuscripts\ManuscriptPage::all();
        foreach ($pages as $page) {
            if ($page->is_online > 0) {
                $page->is_online_new = true;
                $page->save();
            }
        }

        Schema::table('ms_manuscript_pages', function (Blueprint $table) {
            $table->dropColumn('is_online');

            $table->renameColumn("is_online_new", "is_online");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ms_manuscript_pages', function (Blueprint $table) {
            if (Schema::hasColumn('ms_manuscript_pages', 'is_online_new')) {
                $table->dropColumn('is_online_new');
            }
        });
    }
};
