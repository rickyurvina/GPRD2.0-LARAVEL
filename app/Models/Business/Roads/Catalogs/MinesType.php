<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MinesType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperMinesType
 */
class MinesType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_minas';

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
