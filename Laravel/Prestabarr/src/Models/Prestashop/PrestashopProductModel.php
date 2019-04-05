<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopProductModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_product';

    protected $primaryKey = 'id_product';

    protected  $fillable = [
        'id_product',
        'id_supplier',
        'id_manufacturer',
        'id_category_default',
        'id_shop_default',
        'id_tax_rules_group',
        'on_sale',
        'online_only',
        'ean13',
        'isbn',
        'upc',
        'ecotax',
        'quantity',
        'minimal_quantity',
        'low_stock_threshold',
        'low_stock_alert',
        'price',
        'wholesale_price',
        'unity',
        'unit_price_ratio',
        'additional_shipping_cost',
        'reference',
        'supplier_reference',
        'location',
        'width',
        'height',
        'depth',
        'weight',
        'out_of_stock',
        'additional_delivery_times',
        'quantity_discount',
        'customizable',
        'uploadable_files',
        'text_fields',
        'active',
        'redirect_type',
        'id_type_redirected',
        'available_for_order',
        'available_date',
        'show_condition',
        'condition',
        'show_price',
        'indexed',
        'visibility',
        'cache_is_pack',
        'cache_has_attachments',
        'is_virtual',
        'cache_default_attribute',
        'date_add',
        'date_upd',
        'advanced_stock_management',
        'pack_stock_type',
        'state'
    ];

    public $timestamps = false;
}
