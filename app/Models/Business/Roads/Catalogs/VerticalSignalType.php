<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase VerticalSignalType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperVerticalSignalType
 */
class VerticalSignalType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_senal_vertical';

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
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descripcion'
    ];
}
