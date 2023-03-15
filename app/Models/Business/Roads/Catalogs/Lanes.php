<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Lanes
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperLanes
 */
class Lanes extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_carriles';

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
