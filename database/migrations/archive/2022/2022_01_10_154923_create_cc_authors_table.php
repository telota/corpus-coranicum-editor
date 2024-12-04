<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\GeneralCC\CCAuthor;

class CreateCcAuthorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cc_authors', function (Blueprint $table) {
            $table->increments('id');
            $table->string("author_name")->unique();
            $table->text("author_description", 65535)->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `cc_authors` COMMENT 'It represents all authors in the Corpus Coranicum project including colleagues and extern.'");

        // add initial data

        $ccAuthorsData =
            [
                'Michael Marx', 'Nestor Kavvadas', 'Dirk Hartwig',
                'Johanna Schubert', 'Farah C. Artika', 'Manssur Karamzadeh',
                'Yunus C. Öç', 'Tobias J. Jocham', 'Salome Beridze',
                'Charlotte Bohm', 'Sabrina Cimiotti', 'Hadiya Gurtmann',
                'Laura Hinrichsen', 'Tolou Khademalsharieh', 'Nora Reifenstein',
                'Jens Sauer', 'Sophie Schmid', 'Annemarie Jehring',
                'Ali Aghaei', 'Marcus Fraser', 'Elahe Shahpasand',
                'Raheleh Shahpasand', 'Azam Shahpasand', 'Zahra Mollaei',
                'Mojgan Azimian', 'Fatemeh Nayeree', 'Veronika Roth',
                'Jerome Okensky', 'Mohammed Maraqten', 'David Kiltz',
                'Yousef Kouriyhe', 'Nicolai Sinai', 'Vasiliki Chamourgiotaki', 'Antonia Kura'
            ];

        foreach ($ccAuthorsData as $datum) {
            $author = new CCAuthor();
            $author->author_name = $datum;
            $author->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('cc_authors');
    }
}
