<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('qortbl2', function (Blueprint $table) {
            $table->decimal('sure_cc', 3, 0)->default(null)->change();
            $table->decimal('vers_cc', 3, 0)->default(null)->change();
            $table->decimal('wort_cc', 3, 0)->default(null)->change();
            $table->foreign(['sure_cc', 'vers_cc'])->references(['sure', 'vers'])->on('lc_kkoran');
            $table->index(['sure_cc', 'vers_cc']);
            $table->index(['sure_cc', 'vers_cc', 'wort_cc']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('qortbl2', function (Blueprint $table) {
            $table->integer('sure_cc')->default(null)->change();
            $table->integer('vers_cc')->default(null)->change();
            $table->integer('wort_cc')->default(null)->change();
        });
    }
};
