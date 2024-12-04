<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMsManuscriptAntiquityMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ms_manuscript_antiquity_markets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer("manuscript_id")->nullable()->unsigned();
            $table->foreign("manuscript_id")
                ->references("id")->on("ms_manuscript")
                ->onDelete('cascade');
            $table->integer("auction_house_id")->nullable()->unsigned();
            $table->foreign("auction_house_id")
                ->references("id")->on("ms_auction_houses")
                ->onDelete('cascade');
            $table->date('auction_date', 65535)->nullable();
            $table->integer('price')->nullable();
            $table->string('currency')->nullable();
            $table->string("created_by")->nullable();
            $table->string("updated_by")->nullable();
            $table->timestamps();
            $table->unique(['manuscript_id', 'auction_house_id', 'auction_date'], "unique_index");
        });

        DB::statement("ALTER TABLE `ms_manuscript_antiquity_markets` COMMENT 'It represents the exact event when a certain manuscript is auctioned.'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ms_manuscript_antiquity_markets');
    }
}
