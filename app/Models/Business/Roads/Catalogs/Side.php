<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase Side
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperSide
 */
class Side extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_lado';

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
