<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopLangModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_lang';

    protected $primaryKey = 'id_lang';

    protected  $fillable = [
        'id_lang',
        'name',
        'active',
        'iso_code',
        'language_code',
        'locale',
        'date_format_lite',
        'date_format_full',
        'is_rtl'
    ];


    public $timestamps = false;
}
