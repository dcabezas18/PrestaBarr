<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrCommandeDetModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_commandedet';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'fk_commande',
        'fk_parent_line',
        'fk_product',
        'label',
        'description',
        'vat_src_code',
        'tva_tx',
        'localtax1_tx',
        'localtax1_type',
        'localtax2_tx',
        'localtax2_type',
        'qty',
        'remise_percent',
        'remise',
        'fk_remise_except',
        'price',
        'subprice',
        'total_ht',
        'total_tva',
        'total_localtax1',
        'total_localtax2',
        'total_ttc',
        'product_type',
        'date_start',
        'date_en',
        'info_bits',
        'buy_price_ht',
        'fk_product_fournisseur_price',
        'special_code',
        'rang',
        'fk_unit',
        'import_key',
        'fk_commandefourndet',
        'fk_multicurrency',
        'multicurrency_code',
        'multicurrency_subprice',
        'multicurrency_total_ht',
        'multicurrency_total_tva',
        'multicurrency_total_ttc'
    ];

    public $timestamps = false;
}
