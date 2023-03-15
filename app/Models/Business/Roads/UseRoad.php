<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase UseRoad (uso de vía)
 *
 * @property mixed codigo
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperUseRoad
 */
class UseRoad extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_uso_via';

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
