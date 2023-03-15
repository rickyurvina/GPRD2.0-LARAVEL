<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeOfLand (tipo de terreno)
 *
 * @property mixed codigo
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeOfLand
 */
class TypeOfLand extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_terreno';

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
