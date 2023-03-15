<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TerrainType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperTerrainType
 */
class TerrainType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_terreno';

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
