<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeSewer (Tipo de alcantarilla)
 *
 * @property mixed code
 * @property mixed description
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeSewer
 */
class TypeSewer extends Model
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
     * @var array
     */
    protected $fillable = [
        'codigo',
        'descrip'
    ];
}
