<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase SewerMaterial
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperSewerMaterial
 */
class SewerMaterial extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_material_alcantarilla';

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
