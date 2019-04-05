<?php

namespace Prestabarr\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

        'Prestabarr\Events\DolibarrChangeProductStockEvent' => [
            'Prestabarr\Listeners\DolibarrChangeProductStock',
        ],
        'Prestabarr\Events\DolibarrChangeProductPriceEvent' => [
            'Prestabarr\Listeners\DolibarrChangeProductPrice',
        ],
        'Prestabarr\Events\DolibarrToPrestashopProductEvent' => [
            'Prestabarr\Listeners\DolibarrToPrestashopProduct',
        ],
        'Prestabarr\Events\PrestashopToDolibarUpdateProductEvent' => [
            'Prestabarr\Listeners\PrestashopToDolibarUpdateProduct',
        ],
        'Prestabarr\Events\PrestashopToDolibarOrderEvent' => [
            'Prestabarr\Listeners\PrestashopToDolibarOrder',
        ],
        'Prestabarr\Events\PrestashopUpdateProductAttributeEvent' => [
            'Prestabarr\Listeners\PrestashopUpdateProductAttribute',
        ],
        'Prestabarr\Events\DolibarrUpdateProductAttributeEvent' => [
            'Prestabarr\Listeners\DolibarrUpdateProductAttribute',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
