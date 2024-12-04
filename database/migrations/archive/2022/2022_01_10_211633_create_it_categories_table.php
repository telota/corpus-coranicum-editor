<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Umwelttexte\BelegstellenKategorie;
use \App\Models\Intertexts\IntertextCategory;

class CreateItCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('it_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string("category_name")->unique();
            $table->string("classification")->nullable();
            $table->integer("supercategory")->nullable()->unsigned();
            $table->foreign("supercategory")->references("id")->on("it_categories");
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['category_name', 'supercategory'], "unique_index");
        });

        DB::statement("ALTER TABLE `it_categories` COMMENT 'Old table: belegstellen_kategorie. It represents the category of intertexts.'");


        // add initial data

        $initCategory = new IntertextCategory();
        $initCategory->id = 1;
        $initCategory->category_name = 'Super Category.php';
        $initCategory->save();


        // transfer data from 'belegstellen_kategorie' to 'it_categories'

        foreach (BelegstellenKategorie::all() as $category) {

            if ((int) $category->id > 0) {
                $category->id = (int) $category->id;
                $category->save();
                IntertextCategory::create([
                    'category_name' => $category->name,
                    'classification' => $category->classification,
                    'supercategory' => $category->supercategory + 1,
                    'created_at' => $category->created_at,
                    'updated_at' => $category->updated_at
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('it_categories');
    }
}
