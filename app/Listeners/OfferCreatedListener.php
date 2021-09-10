<?php

namespace App\Listeners;

use App\Events\OfferCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Helpers\OneSignalHelper;

class OfferCreatedListener
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
     * @param  OfferCreated  $event
     * @return void
     */
    public function handle(OfferCreated $event)
    {
        $offer = $event->offer;
        $filter = array(
            array(
                "field"=>"tag",
                "key"=>"userId",
                "value"=>"userId_".$offer->clientRequest->client_id,
                "relation"=>"="
            )
        );
        $pushData = array(
            "offer" => $offer
        );

        OneSignalHelper::notification(
            1,
            $offer->service_provider_id, //user_id
            $offer->clientRequest->client_id , //user_id_to_notify
            "NEW_OFFER", //type
            "offer", // group
            $filter, // filter
            $pushData
        );
        
    }
}
