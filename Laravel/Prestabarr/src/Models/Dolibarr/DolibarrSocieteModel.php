<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrSocieteModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_societe';
    
    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'nom',
        'name_alias',
        'entity',
        'ref_ext',
        'ref_int',
        'statut',
        'parent',
        'status',
        'code_client',
        'code_fournisseur',
        'code_compta',
        'code_compta_fournisseur',
        'address',
        'zip',
        'town',
        'fk_departement',
        'fk_pays',
        'fk_account',
        'phone',
        'fax',
        'url',
        'email',
        'skype',
        'fk_effectif',
        'fk_typent',
        'fk_forme_juridique',
        'fk_currency',
        'siren',
        'siret',
        'ape',
        'idprof4',
        'idprof5',
        'idprof6',
        'tva_intra',
        'capital',
        'fk_stcomm',
        'note_private',
        'note_public',
        'model_pdf',
        'prefix_comm',
        'client',
        'fournisseur',
        'supplier_account',
        'fk_prospectlevel',
        'fk_incoterms',
        'location_incoterms',
        'customer_bad',
        'customer_rate',
        'supplier_rate',
        'remise_client',
        'remise_supplier',
        'mode_reglement',
        'cond_reglement',
        'mode_reglement_supplier',
        'cond_reglement_supplier',
        'fk_shipping_method',
        'tva_assuj',
        'localtax1_assuj',
        'localtax1_value',
        'localtax2_assuj',
        'localtax2_value',
        'barcode',
        'fk_barcode_type',
        'price_level',
        'outstanding_limit',
        'order_min_amount',
        'supplier_order_min_amount',
        'default_lang',
        'logo',
        'canvas',
        'fk_entrepot',
        'webservices_url',
        'webservices_key',
        'tms',
        'datec',
        'fk_user_creat',
        'fk_user_modif',
        'fk_multicurrency',
        'multicurrency_code',
        'import_key'
    ];

    public $timestamps = false;

}
