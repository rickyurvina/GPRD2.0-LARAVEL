<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MaterialSewer (Material de alcantarilla)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperMaterialSewer
 */
class MaterialSewer extends Model
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
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
