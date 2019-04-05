<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrStockMouvementModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_stock_mouvement';

    protected $primaryKey = 'rowid';

    protected $fillable = [
        'rowid',
        'tms',
        'datem',
        'fk_product',
        'batch',
        'eatby',
        'sellby',
        'fk_entrepot',
        'value',
        'price',
        'type_mouvement',
        'fk_user_author',
        'label',
        'inventorycode',
        'fk_origin',
        'origintype',
        'model_pdf'
    ];

    public $timestamps = false;
}

