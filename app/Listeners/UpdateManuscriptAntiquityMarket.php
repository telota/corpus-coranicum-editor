<?php

namespace App\Listeners;

use App\Events\UpdateManuskriptEvent;
use App\Models\Manuscripts\ManuscriptAntiquityMarket;
use App\Models\Manuscripts\ManuscriptNew;


class UpdateManuscriptAntiquityMarket
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UpdateManuskriptEvent  $event
     * @return void
     */
    public function handle(UpdateManuskriptEvent $event)
    {

        $request = $event->request;

//        AUCTION HOUSES

        $auctionHouse = collect($request->auction_house)->values();
        $auctionHouse = count($auctionHouse) > 0 ? $auctionHouse[0] : null;

//        DATE

        $antiquityDate = collect($request->antiquity_date)->values();
        $antiquityDate = count($antiquityDate) > 0 ? $antiquityDate[0] : null;

//        PRICE

        $antiquityPrice = collect($request->antiquity_price)->values();
        $antiquityPrice = count($antiquityPrice) > 0 ? $antiquityPrice[0] : null;

        $antiquityCurrency = collect($request->antiquity_currency)->values();
        $antiquityCurrency = count($antiquityCurrency) > 0 ? $antiquityCurrency[0] : null;

        $manuscriptAntiquityMarket = ManuscriptNew::find($event->manuskriptId)->antiquityMarket;

        // Delete item that have been deselected

        if ($manuscriptAntiquityMarket)
        {
            $manuscriptAntiquityMarket->auction_house_id = $auctionHouse;
            $manuscriptAntiquityMarket->auction_date = $antiquityDate;
            $manuscriptAntiquityMarket->price = $antiquityPrice;
            $manuscriptAntiquityMarket->currency = $antiquityCurrency;

            $manuscriptAntiquityMarket->save();

        } else {
            $newAntiquityMarket = ManuscriptAntiquityMarket::firstOrNew([
                "manuscript_id" => $event->manuskriptId,
                "auction_house_id" => $auctionHouse,
                "auction_date" => $antiquityDate,
                "price" => $antiquityPrice,
                "currency" => $antiquityCurrency
            ]);
            $newAntiquityMarket->save();
        }

    }
}
