<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TrackUsage
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperTrackUsage
 */
class TrackUsage extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_uso_via';

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
