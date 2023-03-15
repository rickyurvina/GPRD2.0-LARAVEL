<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase BridgeRollingLayer
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperBridgeRollingLayer
 */
class BridgeRollingLayer extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_capa_rodadura_puente';

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
