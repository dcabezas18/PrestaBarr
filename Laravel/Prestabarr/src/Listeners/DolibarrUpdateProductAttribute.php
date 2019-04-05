<?php

namespace Prestabarr\Listeners;

use Prestabarr\Events\DolibarrUpdateProductAttributeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prestabarr\Events\DolibarrChangeProductStockEvent;
use Prestabarr\Models\Dolibarr\DolibarrProductModel;
use Prestabarr\Models\Dolibarr\DolibarrProductStockModel;
use Prestabarr\Models\Prestashop\PrestashopProductAttributeModel;
use Prestabarr\Models\Prestashop\PrestashopProductModel;
use Prestabarr\Models\Prestashop\PrestashopProductShopModel;
use Prestabarr\Models\Prestashop\PrestashopStockAvailableModel;

class DolibarrUpdateProductAttribute implements ShouldQueue
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
    public function handle(DolibarrUpdateProductAttributeEvent $event)
    {
        $productPrestashopAttribute = PrestashopProductAttributeModel::where('reference', $event->ref)->first();

        \Log::info('[INIT] DolibarrUpdateProductAttribute. Reference='.$event->ref);

        if ($productPrestashopAttribute) {
            $productDolibarr = DolibarrProductModel::where('ref', $event->ref)->first();
            $productPrestashop = PrestashopProductModel::where('id_product', $productPrestashopAttribute->id_product)->first();

            if ($productDolibarr) {
                if ($productPrestashop) {
                    $productPrestashop->price = $productDolibarr->price;
                    $productPrestashop->save();
                    $productShop = PrestashopProductShopModel::where('id_product', $productPrestashop->id_product)->first();
                    $productShop->price = $productDolibarr->price;
                    $productShop->save();
                }

                $productDolibarrStock = DolibarrProductStockModel::where('fk_product', $productDolibarr->rowid)->first();

                if ($productDolibarrStock) {
                    $stockAvailable = PrestashopStockAvailableModel::where('id_product', $productPrestashopAttribute->id_product)
                        ->where('id_product_attribute', $productPrestashopAttribute->id_product_attribute)
                        ->first();

                    if ($stockAvailable) {
                        if ($stockAvailable->quantity != $productDolibarrStock->reel) {
                            $stockAvailable->quantity = $productDolibarrStock->reel;
                            $stockAvailable->save();
                        }

                    } else {
                        \Log::error('[DolibarrUpdateProductAttribute] Stock de referencia no encontrada en Prestashop. Referencia = '.$event->ref);
                    }
                }

            } else {
                \Log::error('[DolibarrUpdateProductAttribute] Referencia no encontrada en ERP. Referencia = '.$event->ref);
            }

        } else {
            \Log::error('[DolibarrUpdateProductAttribute] Referencia no encontrada en Prestashop. Referencia = '.$event->ref);
        }
    }
}