<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase ProductiveSector
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperProductiveSector
 */
class ProductiveSector extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_sector_productivo';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'descrip';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
