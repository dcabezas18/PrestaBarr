<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrSocPeopleModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_socpeople';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid',
        'datec',
        'tms',
        'fk_soc',
        'entity',
        'ref_ext',
        'civility',
        'lastname',
        'firstname',
        'address',
        'zip',
        'town',
        'fk_departement',
        'fk_pays',
        'birthday',
        'poste',
        'phone',
        'phone_perso',
        'phone_mobile',
        'fax',
        'email',
        'jabberid',
        'skype',
        'photo',
        'no_email',
        'priv',
        'fk_user_creat',
        'fk_user_modif',
        'note_private',
        'note_public',
        'default_lang',
        'canvas',
        'import_key',
        'statut'
    ];
    public $timestamps = false;
}
