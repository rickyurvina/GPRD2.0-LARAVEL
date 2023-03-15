<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase AssociatedServiceType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperAssociatedServiceType
 */
class AssociatedServiceType extends Model
{

    /**
     * @var string
     */
    protected $table = 'road_road_tipo_servicio_asociado';

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
