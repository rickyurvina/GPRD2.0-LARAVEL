<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase DayType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperDayType
 */
class DayType extends Model
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
