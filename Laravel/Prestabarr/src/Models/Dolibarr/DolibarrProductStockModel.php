<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrProductStockModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_product_stock';

    protected $primaryKey = 'rowid';

    protected $fillable = [
        'rowid',
        'tms',
        'fk_product',
        'fk_entrepot',
        'reel',
        'import_key'
    ];

    public $timestamps = false;
}

