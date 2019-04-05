<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopCartRuleModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_cart_rule';

    protected $primaryKey = 'id_cart_rule';

    protected  $fillable = [
        'id_cart_rule',
        'id_customer',
        'date_from',
        'date_to',
        'description',
        'quantity',
        'quantity_per_user',
        'priority',
        'partial_use',
        'code',
        'minimum_amount',
        'minimum_amount_tax',
        'minimum_amount_currency',
        'minimum_amount_shipping',
        'country_restriction',
        'carrier_restriction',
        'group_restriction',
        'cart_rule_restriction',
        'product_restriction',
        'shop_restriction',
        'free_shipping',
        'reduction_percent',
        'reduction_amount',
        'reduction_tax',
        'reduction_currency',
        'reduction_product',
        'reduction_exclude_special',
        'gift_product',
        'gift_product_attribute',
        'highlight',
        'active',
        'date_add',
        'date_upd'
    ];


    public $timestamps = false;
}
