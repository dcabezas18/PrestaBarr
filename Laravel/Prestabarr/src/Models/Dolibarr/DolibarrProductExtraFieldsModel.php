<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrProductExtraFieldsModel extends Model
{
    protected $connection = 'dolibarr';

    protected  $table = 'llx_product_extrafields';

    protected $primaryKey = 'rowid';

    protected $fillable = [
        'rowid',
        'tms',
        'fk_object',
        'import_key',
        'longdescript'
    ];

    public $timestamps = false;
}

