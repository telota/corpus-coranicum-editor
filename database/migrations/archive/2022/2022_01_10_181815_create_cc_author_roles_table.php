<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\GeneralCC\AuthorRole;

class CreateCcAuthorRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_author_roles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("author_id")->unsigned();
            $table->foreign("author_id")
                ->references("id")->on("cc_authors")
                ->onDelete("cascade");
            $table->integer("role_id")->unsigned();
            $table->foreign("role_id")
                ->references("id")->on("cc_roles")
                ->onDelete("cascade");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(["author_id", "role_id"]);
        });

        DB::statement("ALTER TABLE `cc_author_roles` COMMENT 'It represents the role of a certain author.'");

        //

        $ccAuthorRolesData = array(
            // manuscript - assistances
            [
                'author_id' => 5,
                'role_id' => 5
            ],
            [
                'author_id' => 6,
                'role_id' => 5
            ],
            [
                'author_id' => 7,
                'role_id' => 5
            ],
            [
                'author_id' => 8,
                'role_id' => 5
            ],
            [
                'author_id' => 9,
                'role_id' => 5
            ],
            [
                'author_id' => 10,
                'role_id' => 5
            ],
            [
                'author_id' => 11,
                'role_id' => 5
            ],
            [
                'author_id' => 12,
                'role_id' => 5
            ],
            [
                'author_id' => 13,
                'role_id' => 5
            ],
            [
                'author_id' => 14,
                'role_id' => 5
            ],
            [
                'author_id' => 15,
                'role_id' => 5
            ],
            [
                'author_id' => 16,
                'role_id' => 5
            ],
            [
                'author_id' => 17,
                'role_id' => 5
            ],
            [
                'author_id' => 18,
                'role_id' => 5
            ],
            // manuscript - metadata
            [
                'author_id' => 1,
                'role_id' => 1
            ],
            [
                'author_id' => 19,
                'role_id' => 1
            ],
            [
                'author_id' => 8,
                'role_id' => 1
            ],
            [
                'author_id' => 20,
                'role_id' => 1
            ],
            [
                'author_id' => 9,
                'role_id' => 1
            ],
            // manuscript - image
            [
                'author_id' => 5,
                'role_id' => 4
            ],
            [
                'author_id' => 8,
                'role_id' => 4
            ],
            [
                'author_id' => 18,
                'role_id' => 4
            ],
            [
                'author_id' => 12,
                'role_id' => 4
            ],
            // manuscript - transliteration
            [
                'author_id' => 21,
                'role_id' => 3
            ],
            [
                'author_id' => 22,
                'role_id' => 3
            ],
            [
                'author_id' => 23,
                'role_id' => 3
            ],
            [
                'author_id' => 24,
                'role_id' => 3
            ],
            [
                'author_id' => 25,
                'role_id' => 3
            ],
            [
                'author_id' => 26,
                'role_id' => 3
            ],
            [
                'author_id' => 9,
                'role_id' => 3
            ],
            [
                'author_id' => 10,
                'role_id' => 3
            ],
            [
                'author_id' => 11,
                'role_id' => 3
            ],
            [
                'author_id' => 12,
                'role_id' => 3
            ],
            [
                'author_id' => 13,
                'role_id' => 3
            ],
            [
                'author_id' => 8,
                'role_id' => 3
            ],
            [
                'author_id' => 14,
                'role_id' => 3
            ],
            [
                'author_id' => 15,
                'role_id' => 3
            ],
            [
                'author_id' => 16,
                'role_id' => 3
            ],
            [
                'author_id' => 17,
                'role_id' => 3
            ],
            [
                'author_id' => 18,
                'role_id' => 3
            ],
            // manuscript - translation
            [
                'author_id' => 1,
                'role_id' => 8
            ],
            // intertext - metadata
            [
                'author_id' => 1,
                'role_id' => 2
            ],
            [
                'author_id' => 2,
                'role_id' => 2
            ],
            [
                'author_id' => 3,
                'role_id' => 2
            ],
            [
                'author_id' => 4,
                'role_id' => 2
            ],
            [
                'author_id' => 29,
                'role_id' => 2
            ],
            [
                'author_id' => 30,
                'role_id' => 2
            ],
            [
                'author_id' => 31,
                'role_id' => 2
            ],
            [
                'author_id' => 32,
                'role_id' => 2
            ],
            [
                'author_id' => 27,
                'role_id' => 2
            ],
            // intertext - information
            [
                'author_id' => 1,
                'role_id' => 6
            ],
            // intertext - translation
            [
                'author_id' => 1,
                'role_id' => 7
            ],
            // intertext - collaboration
            [
                'author_id' => 9,
                'role_id' => 9
            ],
            [
                'author_id' => 27,
                'role_id' => 9
            ],
            [
                'author_id' => 14,
                'role_id' => 9
            ],
            [
                'author_id' => 4,
                'role_id' => 9
            ],
            [
                'author_id' => 28,
                'role_id' => 9
            ],
            // intertext - update
            [
                'author_id' => 33,
                'role_id' => 10
            ],
            // intertext - text editing
            [
                'author_id' => 4,
                'role_id' => 11
            ],
            [
                'author_id' => 34,
                'role_id' => 11
            ]
        );

        foreach ($ccAuthorRolesData as $datum) {
            $authorRole = new AuthorRole();
            $authorRole->author_id = $datum['author_id'];
            $authorRole->role_id = $datum['role_id'];
            $authorRole->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cc_author_roles');
    }
}
