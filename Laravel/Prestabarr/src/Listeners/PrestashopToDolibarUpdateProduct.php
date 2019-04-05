<?php

namespace Prestabarr\Listeners;

use Prestabarr\Events\PrestashopToDolibarUpdateProductEvent;
use Prestabarr\Events\PrestashopUpdateProductAttributeEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Prestabarr\Models\Dolibarr\DolibarrProductModel;
use Prestabarr\Models\Dolibarr\DolibarrProductStockModel;
use Prestabarr\Models\Dolibarr\DolibarrStockMouvementModel;
use Prestabarr\Models\Prestashop\PrestashopProductModel;
use Prestabarr\Models\Prestashop\PrestashopStockAvailableModel;

class PrestashopToDolibarUpdateProduct implements ShouldQueue
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
    public function handle(PrestashopToDolibarUpdateProductEvent $event)
    {
        $productDolibarr = DolibarrProductModel::where('ref', $event->ref)->first();

        if ($productDolibarr) {
            $productDolibarr->price = $event->price;
            $productPrestashop = PrestashopProductModel::where('reference', $event->ref)->first();
            $stockAvailable = PrestashopStockAvailableModel::where('id_product', $productPrestashop->id_product)->first();

            if ($productDolibarr->stock != $stockAvailable->quantity) {
                $productStockDolibarr = DolibarrProductStockModel::where('fk_product', $productDolibarr->rowid)->where('fk_entrepot', $stockAvailable->id_shop)->first();

                if (!$productStockDolibarr) {
                    $productStockDolibarr = new DolibarrProductStockModel();
                    $productStockDolibarr->fk_product = $productDolibarr->rowid;
                    $productStockDolibarr->fk_entrepot = $stockAvailable->id_shop;
                }

                $productStockDolibarr->reel = $stockAvailable->quantity;
                $productStockDolibarr->save();

                if ($productDolibarr->stock > 0) {
                    $stock = ($productDolibarr->stock - $stockAvailable->quantity) * -1;

                } else {
                    $stock = ($productDolibarr->stock + $stockAvailable->quantity);
                }

                $productDolibarr->stock = $stockAvailable->quantity;

                $stockMouvement = new DolibarrStockMouvementModel();
                $stockMouvement->tms = date('Y-m-d H:i:s');
                $stockMouvement->datem = date('Y-m-d H:i:s');
                $stockMouvement->fk_product = $productDolibarr->rowid;
                $stockMouvement->price = $event->price;
                $stockMouvement->value = $stock;
                $stockMouvement->fk_entrepot = $productStockDolibarr->fk_entrepot;
                $stockMouvement->fk_user_author = 1;
                $stockMouvement->label = 'Prestashop';

                $stockMouvement->save();
            }

            $productDolibarr->save();

        } else {
            event(new PrestashopUpdateProductAttributeEvent($event->ref));
        }
    }
}
