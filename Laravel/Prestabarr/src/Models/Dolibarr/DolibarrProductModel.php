<?php

namespace Prestabarr\Models\Dolibarr;

use Illuminate\Database\Eloquent\Model;

class DolibarrProductModel extends Model
{
    protected $connection = 'dolibarr';

    protected $table = 'llx_product';

    protected $primaryKey = 'rowid';

    protected $fillable = [
        'rowid',
        'ref',
        'entity',
        'ref_ext',
        'datec',
        'tms',
        'fk_parent',
        'label',
        'description',
        'note_public',
        'note',
        'customcode',
        'fk_country',
        'price',
        'price_ttc',
        'price_min',
        'price_min_ttc',
        'price_base_type',
        'cost_price',
        'default_vat_code',
        'tva_tx',
        'recuperableonly',
        'localtax1_tx',
        'localtax1_type',
        'localtax2_tx',
        'localtax2_type',
        'fk_user_author',
        'fk_user_modif',
        'tosell',
        'tobuy',
        'onportal',
        'tobatch',
        'fk_product_type',
        'duration',
        'seuil_stock_alerte',
        'url',
        'barcode',
        'fk_barcode_type',
        'accountancy_code_sell',
        'accountancy_code_sell_intra',
        'accountancy_code_sell_export',
        'accountancy_code_buy',
        'partnumber',
        'weight',
        'weight_units',
        'length',
        'length_units',
        'width',
        'width_units',
        'height',
        'height_units',
        'surface',
        'surface_units',
        'volume',
        'volume_units',
        'stock',
        'pmp',
        'fifo',
        'lifo',
        'fk_default_warehouse',
        'canvas',
        'finished',
        'hidden',
        'import_key',
        'model_pdf',
        'fk_price_expression',
        'desiredstock',
        'fk_unit',
        'price_autogen'
    ];

    public $timestamps = false;
}

