<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeInterconnection (tipo interconección)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeInterconnection
 */
class TypeInterconnection extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_interconexion';

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
