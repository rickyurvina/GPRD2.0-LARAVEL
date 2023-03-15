<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Source
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperSource
 */
class Source extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_fuente';

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
