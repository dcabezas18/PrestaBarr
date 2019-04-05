<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrSocieteRibModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_societe_rib';
    
    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'type',
        'label',
        'fk_soc',
        'datec',
        'tms',
        'bank',
        'code_banque',
        'code_guichet',
        'number',
        'cle_rib',
        'bic',
        'iban_prefix',
        'domiciliation',
        'proprio',
        'owner_address',
        'default_rib',
        'rum',
        'date_rum',
        'frstrecur',
        'last_four',
        'card_type',
        'cvn',
        'exp_date_month',
        'exp_date_year',
        'country_code',
        'approved',
        'email',
        'ending_date',
        'max_total_amount_of_all_payments',
        'preapproval_key',
        'starting_date',
        'total_amount_of_all_payments',
        'stripe_card_ref',
        'status',
        'import_key'
    ];

    public $timestamps = false;

    public function societe() {
        return $this->belongsTo(DolibarrSocieteModel::class,'fk_soc');
    }
}
