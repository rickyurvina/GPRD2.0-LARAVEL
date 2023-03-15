<?php

namespace App\Models\Business\Roads\Catalogs;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase SideProtections
 *
 * @package App\Models\Business\Roads\Catalogs
 * @mixin IdeHelperSideProtections
 */
class SideProtections extends Model
{


    /**
     * @var string
     */
    protected $table = 'road_protecciones_laterales';

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
