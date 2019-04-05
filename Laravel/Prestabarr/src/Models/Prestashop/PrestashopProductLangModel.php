<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopProductLangModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_product_lang';

    protected $primaryKey = 'id_product';

    protected  $fillable = [
        'id_product',
        'id_shop',
        'id_lang',
        'description',
        'description_short',
        'link_rewrite',
        'meta_description',
        'meta_keywords',
        'meta_title',
        'name',
        'available_now',
        'available_later',
        'delivery_in_stock',
        'delivery_out_stock'
    ];


    public $timestamps = false;
}
