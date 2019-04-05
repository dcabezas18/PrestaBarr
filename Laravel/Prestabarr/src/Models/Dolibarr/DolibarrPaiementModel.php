<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrPaiementModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_paiement';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'ref',
        'entity',
        'datec',
        'tms',
        'datep',
        'amount',
        'multicurrency_amount',
        'fk_paiement',
        'num_paiement',
        'note',
        'fk_bank',
        'fk_user_creat',
        'fk_user_modif',
        'statut',
        'fk_export_compta'
    ];

    public $timestamps = false;

}
