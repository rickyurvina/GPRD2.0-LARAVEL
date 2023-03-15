<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase State (Estado de vías)
 *
 * @property mixed codigo
 * @property mixed descripcion
 * @package App\Models\Business\Roads
 * @mixin IdeHelperState
 */
class State extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_estado';

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
