<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    private function migrateTable($table_name, $column_name, $role_id)
    {
        $entries = DB::table($table_name)->get();
        foreach ($entries as $e) {
            $author_role = \App\Models\GeneralCC\CCAuthorRole::where('author_id', $e->$column_name)
                ->where('role_id', $role_id)
                ->first();

            if (!isset($author_role)) {
                Log::warn("Problem with table $table_name. No author role found for id ${e['id']}");
            }


            DB::table('ms_manuscript_author_roles')
                ->insert([
                    'manuscript_id' => $e->manuscript_id,
                    'author_role_id' => $author_role->id,
                    'created_by' => $e->created_by,
                    'updated_by' => $e->updated_by,
                ]);
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('ms_manuscript_authors', 'ms_manuscript_author_roles');

        Schema::table('ms_manuscript_author_roles', function (Blueprint $table) {
            $table->timestamp('created_at')
                ->default('CURRENT_TIMESTAMP')
                ->change();
            $table->timestamp('updated_at')
                ->default('CURRENT_TIMESTAMP')
                ->change();

            //Not using eloquent because of created_by, updated_by values that I want to preserve
            $table->after('manuscript_id', function (Blueprint $table) {
                $table->integer('author_id')->unsigned()->nullable()->change();
                $table->integer('author_role_id')->unsigned()->nullable();
                $table->foreign('author_role_id')->references('id')->on('cc_author_roles');
            });

        });

        $entries = \App\Models\Manuscripts\ManuscriptAuthor::all();
        foreach ($entries as $e) {
            $author_role = \App\Models\GeneralCC\CCAuthorRole::where("author_id", $e->author_id)
                ->where('role_id', 1)
                ->first();

            if (!isset($author_role)) {
                Log::alert("No author role found for id " . $e->id);
            }

            Log::info($e->id . $e->author_id);
            DB::table('ms_manuscript_author_roles')
                ->where('id', $e->id)
                ->update([
                    'author_role_id' => $author_role->id,
                ]);
        }

        $this->migrateTable('ms_manuscript_image_editors', 'image_editor_id', 4);
        $this->migrateTable('ms_manuscript_transliteration_authors', "transliteration_author_id", 3);
        $this->migrateTable('ms_manuscript_assistances', 'assistance_id', 5);

        Schema::table('ms_manuscript_author_roles', function (Blueprint $table) {
            $table->dropForeign('ms_manuscript_authors_author_id_foreign');
            $table->dropForeign('ms_manuscript_authors_manuscript_id_foreign');
            $table->dropUnique('unique_index');
        });

        Schema::table('ms_manuscript_author_roles', function (Blueprint $table) {
            $table->dropColumn('author_id');
            $table->foreign('manuscript_id')->references('id')->on('ms_manuscript');
            $table->unique(['manuscript_id', 'author_role_id']);
        });

        Schema::drop('ms_manuscript_image_editors');
        Schema::drop('ms_manuscript_transliteration_authors');
        Schema::drop('ms_manuscript_assistances');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
