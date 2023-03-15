<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\RollingSurface;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase RollingSurfaceRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class RollingSurfaceRepository extends Repository
{
    /**
     * Constructor de RollingSurfaceRepository.
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
        return RollingSurface::class;
    }

    /**
     * Actualizar en la BD la información de una superficie de rodadura.
     *
     * @param array $data
     * @param RollingSurface $entity
     *
     * @return RollingSurface|null
     */
    public function updateFromArray(array $data, RollingSurface $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nueva superficie de rodadura.
     *
     * @param array $data
     *
     * @return RollingSurface|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}