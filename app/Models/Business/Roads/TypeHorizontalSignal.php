<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeHorizontalSignal (tipo de senalización horizontal)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeHorizontalSignal
 */
class TypeHorizontalSignal extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_senal_horizontal';

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
