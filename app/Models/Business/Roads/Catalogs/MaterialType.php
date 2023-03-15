<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MaterialType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperMaterialType
 */
class MaterialType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_material';

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
