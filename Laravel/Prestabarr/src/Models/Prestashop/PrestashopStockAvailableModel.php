<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopStockAvailableModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_stock_available';

    protected $primaryKey = 'id_stock_available';

    protected  $fillable = [
        'id_stock_available',
        'id_product',
        'id_product_attribute',
        'id_shop',
        'id_shop_group',
        'quantity',
        'physical_quantity',
        'reserved_quantity',
        'depends_on_stock',
        'out_of_stock'
    ];

    public $timestamps = false;
}
