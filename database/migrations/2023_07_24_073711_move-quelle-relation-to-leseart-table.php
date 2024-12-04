<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $leseart_quellen = DB::table('lc_leseart_quelle')->get();
        foreach($leseart_quellen as $lq)
        {
            $leseart_id = $lq->leseart;
            $leseart = DB::table('lc_leseart')
                ->where('id', $leseart_id)
                ->first();

            if(!isset($leseart)){
                throw new Exception("Couldn't find leseart $leseart_id.");
            }
            if(isset($leseart->quelle_id)){
                throw new Exception("Quelle already set for leseart $leseart_id.");
            }

            DB::table('lc_leseart')
                ->where('id', $leseart_id)
                ->update(["quelle_id"=>$lq->quelle]);
        }
        Schema::drop('lc_leseart_quelle');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('lc_leseart_quelle')->update(['quelle_id' => null]);
    }
};
