<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase RoundSurfaceType (tipo de superficie rodadura)
 *
 * @property mixed codigo
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperRoundSurfaceType
 */
class RoundSurfaceType extends Model
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
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
