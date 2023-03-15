<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase TypeConversationNeeds (tipo necesidades de conservación)
 *
 * @property mixed code
 * @property mixed descrip
 * @package App\Models\Business\Roads
 * @mixin IdeHelperTypeConversationNeeds
 */
class TypeConversationNeeds extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_tipo_necesidad_conservacion';

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
