<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase PopulationType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperPopulationType
 */
class PopulationType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_poblacion';

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
