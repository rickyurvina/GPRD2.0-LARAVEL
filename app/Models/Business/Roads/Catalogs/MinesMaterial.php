<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MinesMaterial
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperMinesMaterial
 */
class MinesMaterial extends Model
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
