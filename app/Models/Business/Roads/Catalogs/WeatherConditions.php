<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase WeatherConditions
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperWeatherConditions
 */
class WeatherConditions extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_condiciones_climaticas';

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
