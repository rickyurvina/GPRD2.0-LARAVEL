<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase RollingSurfaceType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperRollingSurfaceType
 */
class RollingSurfaceType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_superficie_rodadura';

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
     * Opción OTRO
     */
    const OTHER = 'OTRO';

    /**
     * Opción SIN DETERMINAR
     */
    const WITHOUT_DETERMINING = 'SIN DETERMINAR';

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
