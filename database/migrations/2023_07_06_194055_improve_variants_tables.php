<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::drop('lc_leser_leseart');

        $to_change = [
            "lc_variante" => ['id', 'leseart', 'wort'],
            "lc_leseart_quelle" => ['id', 'leseart', 'quelle'],
            "lc_leseart_leser" => ['id', 'leseart', 'leser'],
            "lc_leseart" => ['sure', 'vers'],
        ];

        foreach ($to_change as $table => $columns) {
            Schema::table($table, function (Blueprint $table) use ($columns) {
                foreach ($columns as $c) {
                    if($c == 'id'){
                       $table->increments($c)->change();
                    }else{
                        $table->unsignedInteger($c)->change();
                    }


                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
