<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase CriticalPointType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperCriticalPointType
 */
class CriticalPointType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_punto_critico';

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
