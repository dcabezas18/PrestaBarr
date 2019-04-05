<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopAddressModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_address';

    protected $primaryKey = 'id_address';

    protected  $fillable = [
        'id_address',
        'id_country',
        'id_state',
        'id_customer',
        'id_manufacturer',
        'id_supplier',
        'id_warehouse',
        'alias',
        'company',
        'lastname',
        'firstname',
        'address1',
        'address2',
        'postcode',
        'city',
        'other',
        'phone',
        'phone_mobile',
        'vat_number',
        'dni',
        'date_add',
        'date_upd',
        'active',
        'deleted'
    ];


    public $timestamps = false;
}
