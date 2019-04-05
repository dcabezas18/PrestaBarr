<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopProductAttributeModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_product_attribute';

    protected $primaryKey = 'id_product_attribute';

    protected  $fillable = [
        'id_product_attribute',
        'id_product',
        'reference',
        'supplier_reference',
        'location',
        'ean13',
        'isbn',
        'upc',
        'wholesale_price',
        'price',
        'ecotax',
        'quantity',
        'weight',
        'unit_price_impact',
        'default_on',
        'minimal_quantity',
        'low_stock_threshold',
        'low_stock_alert',
        'available_date'
    ];


    public $timestamps = false;
}
