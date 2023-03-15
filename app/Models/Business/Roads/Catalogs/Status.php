<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Status
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperStatus
 */
class Status extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_estado';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'descripcion';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * Opción SIN DETERMINAR
     */
    const WITHOUT_DETERMINING = 'SIN DETERMINAR';

    /**
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
