<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase ClimaticCondition (condiciones climaticas)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperClimaticCondition
 */
class ClimaticCondition extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_condiciones_climaticas';

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
