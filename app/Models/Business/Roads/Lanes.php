<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Lanes (Carriles)
 *
 * @property mixed code
 * @property mixed description
 * @package App\Models\Business\Roads
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
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
