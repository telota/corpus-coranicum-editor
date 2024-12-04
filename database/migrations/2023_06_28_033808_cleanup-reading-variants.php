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
        Schema::table('lc_variante', function (Blueprint $table) {
            $table->dropColumn('alt_sure');
            $table->dropColumn('alt_vers');
            $table->dropColumn('alt_wort');
        });

        \App\Models\Lesarten\Variante::where('variante',"=","")->delete();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
