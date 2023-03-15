<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeConservationNeed
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperTypeConservationNeed
 */
class TypeConservationNeed extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_necesidad_conservacion';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'descrip';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
