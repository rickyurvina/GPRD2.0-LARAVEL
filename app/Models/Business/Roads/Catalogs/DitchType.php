<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase DitchType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperDitchType
 */
class DitchType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_cuneta';

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
