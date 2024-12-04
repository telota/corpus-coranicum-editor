<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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

        Schema::rename('ms_auction_houses','ms_antiquity_markets');
        foreach (['ms_antiquity_markets', 'ms_manuscript_antiquity_markets'] as $table) {
            Schema::table($table, function (Blueprint $t) {
                $t->timestamp('created_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->nullable()
                    ->change();
                $t->timestamp('updated_at')
                    ->default('CURRENT_TIMESTAMP')
                    ->nullable()
                    ->change();
            });


        }

        DB::statement("ALTER TABLE `ms_antiquity_markets` comment 'The antiquity markets where manuscripts are bought and sold.'");

        Schema::table('ms_antiquity_markets', function(Blueprint $table){
            $table->renameColumn('auction_house','antiquity_market');
        });

        Schema::table('ms_manuscript_antiquity_markets', function (Blueprint $table){
            $table->renameColumn('auction_house_id','antiquity_market_id');
            $table->dropColumn(['auction_date','price','currency']);

        });

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
};
