<?php

namespace Prestabarr\Models\Prestashop;

use Illuminate\Database\Eloquent\Model;

class PrestashopCustomerModel extends Model
{
    protected $connection = 'prestashop';

    protected  $table = 'ps_customer';

    protected $primaryKey = 'id_customer';

    protected  $fillable = [
        'id_customer',
        'id_shop_group',
        'id_shop',
        'id_gender',
        'id_default_group',
        'id_lang',
        'id_risk',
        'company',
        'siret',
        'ape',
        'firstname',
        'lastname',
        'email',
        'passwd',
        'last_passwd_gen',
        'birthday',
        'newsletter',
        'ip_registration_newsletter',
        'newsletter_date_add',
        'optin',
        'website',
        'outstanding_allow_amount',
        'show_public_prices',
        'max_payment_days',
        'secure_key',
        'note',
        'active',
        'is_guest',
        'deleted',
        'date_add',
        'date_upd',
        'reset_password_token',
        'reset_password_validity'
    ];


    public $timestamps = false;
}
