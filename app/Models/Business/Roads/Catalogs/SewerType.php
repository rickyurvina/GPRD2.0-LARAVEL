<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase SewerType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperSewerType
 */
class SewerType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_alcantarilla';

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
