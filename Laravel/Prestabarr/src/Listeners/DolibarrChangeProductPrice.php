<?php

namespace Prestabarr\Listeners;

use Prestabarr\Events\DolibarrUpdateProductAttributeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prestabarr\Events\DolibarrChangeProductPriceEvent;
use Prestabarr\Models\Prestashop\PrestashopProductModel;
use Prestabarr\Models\Prestashop\PrestashopProductShopModel;

class DolibarrChangeProductPrice implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle(DolibarrChangeProductPriceEvent $event)
    {
        $productPrestashop = PrestashopProductModel::where('reference', $event->ref)->first();

        if ($productPrestashop) {
            $productPrestashop->price = $event->price;
            $productPrestashop->save();
            $productShop = PrestashopProductShopModel::where('id_product', $productPrestashop->id_product)->first();
            $productShop->price = $event->price;
            $productShop->save();
            
        } else {
            event(new DolibarrUpdateProductAttributeEvent($event->ref));
        }

    }
}
