<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrBarcodeClientsModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_barcode_clients';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid', 'barcode', 'fk_societe', 'tms'
    ];
    public $timestamps = false;
}
