<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrBarcodePercentagesModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_barcode_percentages';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid', 'barcode_client_id', 'parent_barcode_percentage_id', 'barcode_type_id', 'percentage'
    ];
    public $timestamps = false;
}
