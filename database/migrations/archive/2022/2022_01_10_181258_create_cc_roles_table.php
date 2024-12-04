<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\GeneralCC\CCRole;

class CreateCcRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string("role_name");
            $table->integer("module_id")->unsigned();
            $table->foreign("module_id")->references("id")->on("cc_modules");
            $table->text("role_description", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['role_name', 'module_id']);
        });

        DB::statement("ALTER TABLE `cc_roles` COMMENT 'It represents and describes the roles of authors in the project.'");

        //   add initial data

        $ccRolesData = array(
            [
                'role_name' => 'metadata',
                'module_id' => 1,
                'role_description' => 'It represents the colleagues who determine the metadata of manuscripts.'
            ],
            [
                'role_name' => 'metadata',
                'module_id' => 2,
                'role_description' => 'It represents the authors of metadata intertexts.'
            ],
            [
                'role_name' => 'transliteration',
                'module_id' => 1,
                'role_description' => 'It represents the colleagues who transliterate manuscript pages into the standard Kairo Quran.'
            ],
            [
                'role_name' => 'image',
                'module_id' => 1,
                'role_description' => 'It represents the colleagues who edit manuscript page images.'
            ],
            [
                'role_name' => 'assistance',
                'module_id' => 1,
                'role_description' => 'It represents colleagues who assist during the study of manuscripts.'
            ],
            [
                'role_name' => 'information',
                'module_id' => 2,
                'role_description' => 'It represents the authors of any information texts in intertext module.'
            ],
            [
                'role_name' => 'translation',
                'module_id' => 2,
                'role_description' => 'It represents the translators of any texts in intertext module.'
            ],
            [
                'role_name' => 'translation',
                'module_id' => 1,
                'role_description' => 'It represents the translators of any texts in manuscript module.'
            ],
            [
                'role_name' => 'collaboration',
                'module_id' => 2,
                'role_description' => 'It represents the collaborators of any texts in intertext module.'
            ],
            [
                'role_name' => 'update',
                'module_id' => 2,
                'role_description' => 'It represents the updaters of any texts in intertext module.'
            ],
            [
                'role_name' => 'text_editing',
                'module_id' => 2,
                'role_description' => 'It represents the text editors of any texts in intertext module.'
            ],
        );

        foreach ($ccRolesData as $datum) {
            $role = new CCRole();
            $role->role_name = $datum['role_name'];
            $role->module_id = $datum['module_id'];
            $role->role_description = $datum['role_description'];
            $role->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cc_roles');
    }
}
