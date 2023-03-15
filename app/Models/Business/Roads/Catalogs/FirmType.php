<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase FirmType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperFirmType
 */
class FirmType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_firme';

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
