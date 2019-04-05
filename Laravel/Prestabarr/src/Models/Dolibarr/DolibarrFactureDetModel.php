<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrFactureDetModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_facturedet';

    protected $primaryKey = 'rowid';

    protected $fillable = [
        'rowid',
        'facnumber',
        'entity',
        'ref_ext',
        'ref_int',
        'ref_client',
        'type',
        'increment',
        'fk_soc',
        'datec',
        'datef',
        'date_pointoftax',
        'date_valid',
        'tms',
        'paye',
        'amount',
        'remise_percent',
        'remise_absolue',
        'remise',
        'close_code',
        'close_note',
        'tva',
        'localtax1',
        'localtax2',
        'revenuestamp',
        'total',
        'total_ttc',
        'fk_statut',
        'fk_user_author',
        'fk_user_modif',
        'fk_user_valid',
        'fk_fac_rec_source',
        'fk_facture_source',
        'fk_projet',
        'fk_account',
        'fk_currency',
        'fk_cond_reglement',
        'fk_mode_reglement',
        'date_lim_reglement',
        'note_private',
        'note_public',
        'model_pdf',
        'last_main_doc',
        'fk_incoterms',
        'location_incoterms',
        'situation_cycle_ref',
        'situation_counter',
        'situation_final',
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
