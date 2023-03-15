<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase HorizontalSignalType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperHorizontalSignalType
 */
class HorizontalSignalType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_senal_horizontal';

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
