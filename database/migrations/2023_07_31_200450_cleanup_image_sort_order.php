<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = \App\Models\User::where('name','Marcus Lampert')->first();
        Auth::login($user);

        $images = \App\Models\Manuscripts\ManuscriptPageImage::all();

        $images->groupBy('manuscript_page_id')
                ->each(function($is){
                    $is->sortBy('sort')
                        ->values()
                        ->each(function($i, $index){
                            $i->sort = $index + 1;
                            $i->save();
                        });
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
