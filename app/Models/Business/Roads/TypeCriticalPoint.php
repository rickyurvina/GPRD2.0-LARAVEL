<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeCriticalPoint (tipo punto crítico)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeCriticalPoint
 */
class TypeCriticalPoint extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_punto_critico';

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
