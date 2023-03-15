<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeVertical (tipo de senalización vertical)
 *
 * @property mixed code
 * @property mixed descripcion
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeVerticalSignal
 */
class TypeVerticalSignal extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_senal_vertical';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
