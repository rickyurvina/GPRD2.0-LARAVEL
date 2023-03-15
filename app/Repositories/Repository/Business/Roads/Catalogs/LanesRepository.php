<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\Lanes;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase LanesRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class LanesRepository extends Repository
{
    /**
     * Constructor de LanesRepository.
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
        return Lanes::class;
    }

    /**
     * Obtener de la BD una colección de todos los tipos de carriles excepto 'SIN DETERMINAR.
     *
     * @return mixed
     */
    public function listActive()
    {
        return $this->model->where('descrip', '<>', Lanes::WITHOUT_DETERMINING)->get();
    }
}