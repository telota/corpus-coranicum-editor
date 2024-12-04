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
        Schema::table('lc_kkoran', function (Blueprint $table) {
            $table->decimal('sure', 3, 0)->nullable()->default(null)->change();
            $table->decimal('vers', 3, 0)->nullable()->default(null)->change();
            $table->decimal('wort', 3, 0)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lc_kkoran', function (Blueprint $table) {
            $table->unsignedInteger('sure')->notNull()->default(0)->change();
            $table->unsignedInteger('vers')->notNull()->default(0)->change();
            $table->unsignedInteger('wort')->notNull()->default(0)->change();
        });
    }
};
