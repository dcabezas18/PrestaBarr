<?php

namespace Prestabarr\Listeners;

use Prestabarr\Events\DolibarrUpdateProductAttributeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prestabarr\Events\DolibarrChangeProductStockEvent;
use Prestabarr\Models\Dolibarr\DolibarrProductModel;
use Prestabarr\Models\Dolibarr\DolibarrProductStockModel;
use Prestabarr\Models\Prestashop\PrestashopProductModel;
use Prestabarr\Models\Prestashop\PrestashopStockAvailableModel;

class DolibarrChangeProductStock implements ShouldQueue
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
    public function handle(DolibarrChangeProductStockEvent $event)
    {
        $productPrestashop = PrestashopProductModel::where('reference', $event->ref)->first();
        \Log::info('[INIT] ChangeDolibarrProduct. Reference='.$event->ref);
        if ($productPrestashop) {
            if (!$event->stock) $event->stock = 0;
            $productPrestashop->quantity = $event->stock;
            $productPrestashop->save();
            $stockAvailable = PrestashopStockAvailableModel::where('id_product', $productPrestashop->id_product)->first();
            $productDolibarr = DolibarrProductModel::where('ref', $event->ref)->first();
            $productDolibarrStock = DolibarrProductStockModel::where('fk_product', $productDolibarr->rowid)->first();

            if (!$stockAvailable) {
                $stockAvailable = new PrestashopStockAvailableModel();
                $stockAvailable->id_product = $productPrestashop->id_product;
                $stockAvailable->id_product_attribute = 0;
                $stockAvailable->id_shop = $productDolibarrStock->fk_entrepot;
                $stockAvailable->id_shop_group = 0;
            }

            $stockAvailable->quantity = $event->stock;
            $stockAvailable->physical_quantity = $event->stock;
            $stockAvailable->save();

        } else {
            event(new DolibarrUpdateProductAttributeEvent($event->ref));
        }

    }
}