<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopOrderDetailModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_order_detail';

    protected $primaryKey = 'id_order_detail';

    protected  $fillable = [
        'id_order_detail',
        'id_order',
        'id_order_invoice',
        'id_warehouse',
        'id_shop',
        'product_id',
        'product_attribute_id',
        'id_customization',
        'product_name',
        'product_quantity',
        'product_quantity_in_stock',
        'product_quantity_refunded',
        'product_quantity_return',
        'product_quantity_reinjected',
        'product_price',
        'reduction_percent',
        'reduction_amount',
        'reduction_amount_tax_incl',
        'reduction_amount_tax_excl',
        'group_reduction',
        'product_quantity_discount',
        'product_ean13',
        'product_isbn',
        'product_upc',
        'product_reference',
        'product_supplier_reference',
        'product_weight',
        'id_tax_rules_group',
        'tax_computation_method',
        'tax_name',
        'tax_rate',
        'ecotax',
        'ecotax_tax_rate',
        'discount_quantity_applied',
        'download_hash',
        'download_nb',
        'download_deadline',
        'total_price_tax_incl',
        'total_price_tax_excl',
        'unit_price_tax_incl',
        'unit_price_tax_excl',
        'total_shipping_price_tax_incl',
        'total_shipping_price_tax_excl',
        'purchase_supplier_price',
        'original_product_price',
        'original_wholesale_price'
    ];


    public $timestamps = false;
}
