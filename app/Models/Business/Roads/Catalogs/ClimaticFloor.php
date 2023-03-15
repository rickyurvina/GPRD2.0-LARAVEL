<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase ClimaticFloor
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperClimaticFloor
 */
class ClimaticFloor extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_piso_climatico';

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
