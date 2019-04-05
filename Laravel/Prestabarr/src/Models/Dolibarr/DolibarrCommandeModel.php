<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrCommandeModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_commande';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'ref',
        'entity',
        'ref_ext',
        'ref_int',
        'ref_client',
        'fk_soc',
        'fk_projet',
        'tms',
        'date_creation',
        'date_valid',
        'date_cloture',
        'date_commande',
        'fk_user_author',
        'fk_user_modif',
        'fk_user_valid',
        'fk_user_cloture',
        'source',
        'fk_statut',
        'amount_ht',
        'remise_percent',
        'remise_absolue',
        'remise',
        'tva',
        'localtax1',
        'localtax2',
        'total_ht',
        'total_ttc',
        'note_private',
        'note_public',
        'model_pdf',
        'last_main_doc',
        'facture',
        'fk_account',
        'fk_currency',
        'fk_cond_reglement',
        'fk_mode_reglement',
        'date_livraison',
        'fk_shipping_method',
        'fk_warehouse',
        'fk_availability',
        'fk_input_reason',
        'fk_delivery_address',
        'fk_incoterms',
        'location_incoterms',
        'import_key',
        'extraparams',
        'fk_multicurrency',
        'multicurrency_code',
        'multicurrency_tx',
        'multicurrency_total_ht',
        'multicurrency_total_tva',
        'multicurrency_total_ttc'
    ];

    public $timestamps = false;
}
