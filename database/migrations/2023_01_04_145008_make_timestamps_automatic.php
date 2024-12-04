<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class MakeTimestampsAutomatic extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tables = [

            'ms_places',
            'ms_manuscript',
            'ms_manuscript_mapping',
            'ms_manuscript_pages',
            'ms_manuscript_pages_mapping',
            'ms_manuscript_pages_images',
        ];


        foreach ($tables as $table) {
            Schema::table(
                $table,
                function (Blueprint $table) {
                    $table->dropColumn('created_at');
                    $table->dropColumn('updated_at');
                }
            );

            Schema::table(
                $table,
                function (Blueprint $table) {
                    $table->timestamp('created_at')
                        ->default(DB::raw('CURRENT_TIMESTAMP'));
                    $table->timestamp('updated_at')
                        ->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
                }
            );
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
