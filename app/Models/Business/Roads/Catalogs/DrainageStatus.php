<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase DrainageStatus
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperDrainageStatus
 */
class DrainageStatus extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_est_drenaje';

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
