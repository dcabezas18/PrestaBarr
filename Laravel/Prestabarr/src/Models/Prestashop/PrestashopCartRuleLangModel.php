<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopCartRuleLangModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_cart_rule_lang';

    protected $primaryKey = 'id_cart_rule';

    protected  $fillable = [
        'id_cart_rule','id_lang','name'
    ];


    public $timestamps = false;
}
