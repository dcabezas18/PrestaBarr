<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopProductShopModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_product_shop';

    protected $primaryKey = 'id_product';

    protected  $fillable = [
        'id_product',
        'id_shop',
        'id_category_default',
        'id_tax_rules_group',
        'on_sale',
        'online_only',
        'ecotax',
        'minimal_quantity',
        'low_stock_threshold',
        'low_stock_alert',
        'price',
        'wholesale_price',
        'unity',
        'unit_price_ratio',
        'additional_shipping_cost',
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
        'cache_default_attribute',
        'advanced_stock_management',
        'date_add',
        'date_upd',
        'pack_stock_type'];

    public $timestamps = false;
}
