<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\RollingSurfaceType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase RollingSurfaceTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class RollingSurfaceTypeRepository extends Repository
{
    /**
     * Constructor de RollingSurfaceTypeRepository.
     *
     * @param App $app
     * @param Collection $collection
     *
     * @throws RepositoryException
     */
    public function __construct(App $app, Collection $collection)
    {
        parent::__construct($app, $collection);
    }

    /**
     * Especificar el nombre de la clase del modelo.
     *
     * @return mixed|string
     */
    function model()
    {
        return RollingSurfaceType::class;
    }

    /**
     * Obtener de la BD una colección de todos los tipos de carriles excepto 'SIN DETERMINAR' y 'OTRO'.
     *
     * @return mixed
     */
    public function listActive()
    {
        return $this->model->where('descrip', '<>', RollingSurfaceType::OTHER)->where('descrip', '<>', RollingSurfaceType::WITHOUT_DETERMINING)->get();
    }
}