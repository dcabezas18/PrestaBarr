<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopOrderCartRuleModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_order_cart_rule';

    protected $primaryKey = 'id_order_cart_rule';

    protected  $fillable = [
        'id_order_cart_rule',
        'id_order',
        'id_cart_rule',
        'id_order_invoice',
        'name',
        'value',
        'value_tax_excl',
        'free_shipping'
    ];

    public $timestamps = false;
}
