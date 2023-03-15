<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase RollingLeatherBridge (capa de rodadura de puentes)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperRollingLeatherBridge
 */
class RollingLeatherBridge extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_capa_rodadura_puente';

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
