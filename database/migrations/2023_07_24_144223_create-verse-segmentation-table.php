<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private static $vers_seg = [
        "single" => "single-verses-seperator",
        "decades" => "decades",
        "five" => "five-verses-seperator",
        "abjad" => "abjad-numbers",
        "headings" => "Sura headings",
        "guz" => "marks of ǧuzʾ",
        "fatihat" => "fatihat",
        "khatimat" => "khatimat"
    ];
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $user = \App\Models\User::where('name','DATA_MIGRATION')->first();
        Auth::login($user);

        Schema::create('ms_verse_segmentations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        Schema::create('ms_manuscript_verse_segmentations', function(Blueprint$table){
            $table->increments('id');
            $table->integer("manuscript_id")->unsigned();
            $table->foreign("manuscript_id")->references("id")->on("ms_manuscript");
            $table->integer("verse_segmentation_id")->unsigned();
            $table->foreign("verse_segmentation_id")->references("id")->on("ms_verse_segmentations");
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });


        foreach (self::$vers_seg as $vs)
        {
            $model = new \App\Models\Manuscripts\VerseSegmentation();
            $model->name = $vs;
            $model->save();
        }


        $old = DB::table('ms_manuscript_verssegmentations')->get();
        foreach($old as $o)
        {
           $name = $o->segmentation;
           $vs = \App\Models\Manuscripts\VerseSegmentation::where('name', $name)->first();
           if(isset($vs))
           {
               $mvs = new \App\Models\Manuscripts\ManuscriptVerseSegmentation();
               $mvs->manuscript_id = $o->manuscript_id;
               $mvs->verse_segmentation_id = $vs->id;
               $mvs->created_by = $o->created_by;
               $mvs->updated_by = $o->updated_by;
               $mvs->created_at = $o->created_at;
               $mvs->updated_at = $o->updated_at;
               $mvs->save();
           }

        }

        Schema::drop('ms_manuscript_verssegmentations');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::drop('ms_verse_segmentation');
        //
    }
};
