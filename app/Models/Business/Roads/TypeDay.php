<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeDay (tipo día)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeDay
 */
class TypeDay extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_dia';

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
