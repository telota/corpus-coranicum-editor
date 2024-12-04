<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Models\Manuscripts\AuctionHouse;

class CreateMsAuctionHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_auction_houses', function (Blueprint $table) {
            $table->increments('id');
            $table->string("auction_house")->nullable()->unique();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
        });

        DB::statement("ALTER TABLE `ms_auction_houses` COMMENT 'It represents the auction houses where antiquity markets were held.'");

        // add initial data

        $msAuctionHousesData =
            [
                'Christies', 'Sotheby', 'Bonham',
                'Drouot', 'Nancy enchères', 'Quarich'
            ];

        foreach ($msAuctionHousesData as $datum) {
            $auctionHouse = new AuctionHouse();
            $auctionHouse->auction_house = $datum;
            $auctionHouse->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_auction_houses');
    }
}
