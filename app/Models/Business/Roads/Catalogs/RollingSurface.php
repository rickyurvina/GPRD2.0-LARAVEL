<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase RollingSurface
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperRollingSurface
 */
class RollingSurface extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_superficie_rodadura';

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
