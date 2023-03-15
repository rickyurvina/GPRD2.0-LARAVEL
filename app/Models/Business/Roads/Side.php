<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Side (lado)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperSide
 */
class Side extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_lado';

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
