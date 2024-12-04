<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Models\Manuscripts\ManuscriptNew;

class UpdateMsManuscriptPagesImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $manuscriptList = [27, 578, 382, 383, 325, 26, 28, 13, 158, 159, 160, 161, 326,
            496, 497, 498, 499, 500, 31, 853, 854, 517,
            573, 574, 575, 576, 577, 579, 580, 581, 582, 157];
        foreach ($manuscriptList as $manuscriptID) {
            $manuscript = ManuscriptNew::find($manuscriptID);
            $manuscriptPages = $manuscript->manuscriptPages;
            foreach ($manuscriptPages as $manuscriptPage) {
                $sort = count($manuscriptPage->images);
                if ($sort < 2) continue;
                foreach ($manuscriptPage->images->sortBy('id') as $image) {
                    $image->sort = $sort;
                    $image->save();
                    $sort--;
                }
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
        //
    }
}
