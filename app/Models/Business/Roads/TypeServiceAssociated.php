<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeServiceAssociated (Tipo de servicio asociado)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeServiceAssociated
 */
class TypeServiceAssociated extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_servicio_asociado';

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
