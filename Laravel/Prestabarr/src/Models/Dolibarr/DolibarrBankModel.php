<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrBankModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_bank';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'datec',
        'tms',
        'datev',
        'dateo',
        'amount',
        'label',
        'fk_account',
        'fk_user_author',
        'fk_user_rappro',
        'fk_type',
        'num_releve',
        'num_chq',
        'numero_compte',
        'rappro',
        'note',
        'fk_bordereau',
        'banque',
        'emetteur',
        'author'
    ];
    public $timestamps = false;
}
