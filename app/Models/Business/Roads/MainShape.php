<?php

namespace App\Models\Business\Roads;

use Illuminate\Database\Eloquent\Model;

/**
 * Clase MainShape (capa vectorial por provincia)
 *
 * @package App\Models\Business\Roads
 * @mixin IdeHelperMainShape
 */
class MainShape extends Model
{



    /**
     * @var string
     */
    protected $table = 'road_shape_principal';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var string
     */
    protected $primaryKey = 'gid';

    /**
     * Maximo de archivos permitidos al subir
     */
    const MAX_FILE_UPLOAD = 5;

    /**
     * Maximo tamaño para subir archivos (bytes)
     */
    const MAX_SIZE_UPLOAD = 100000000;

    /**
     * Maximo tamaño para subir archivos (bytes)
     */
    const STRING_MAX_SIZE_UPLOAD = '100 Mb';

    /**
     * tipo de archivo dbf
     */
    const EXTENSION_DBF = 'dbf';

    /**
     * tipo de archivo shp
     */
    const EXTENSION_SHP = 'shp';

    /**
     * Shape de fondo
     */
    const IS_PRIMARY = 1;

    /**
     * @var array
     */
    protected $fillable = [
        'gid',
        'codigo',
        'path',
        'name',
        'extension',
        'is_primary'
    ];
}
