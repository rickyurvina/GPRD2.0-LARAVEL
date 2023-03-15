<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase DrainageType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperDrainageType
 */
class DrainageType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_drenaje';

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
