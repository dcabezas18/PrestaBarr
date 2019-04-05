<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrReferedPurchasesModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_refered_purchases';

    protected $primaryKey = 'rowid';
    
    protected $fillable = [
        'rowid', 'barcode_client_id', 'fk_facture', 'total_amount'
    ];
    public $timestamps = false;

    public function facture() {
        return $this->belongsTo(DolibarrFactureModel::class,'fk_facture');
    }
}
