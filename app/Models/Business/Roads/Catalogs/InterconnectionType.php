<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase InterconnectionType
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperInterconnectionType
 */
class InterconnectionType extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_tipo_interconexion';

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
