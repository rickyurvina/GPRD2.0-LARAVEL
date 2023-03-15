<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MaterialMines (material de minas)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperMaterialMines
 */
class MaterialMines extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_material_minas';

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
