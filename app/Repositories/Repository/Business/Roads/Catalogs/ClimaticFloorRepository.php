<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\ClimaticFloor;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase ClimaticFloorRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class ClimaticFloorRepository extends Repository
{
    /**
     * Constructor de ClimaticFloorRepository.
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
        return ClimaticFloor::class;
    }

    /**
     * Actualizar en la BD la información de un piso climático.
     *
     * @param array $data
     * @param ClimaticFloor $entity
     *
     * @return ClimaticFloor|null
     */
    public function updateFromArray(array $data, ClimaticFloor $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo piso climático.
     *
     * @param array $data
     *
     * @return ClimaticFloor|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}