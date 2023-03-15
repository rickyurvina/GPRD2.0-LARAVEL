<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\DrainageStatus;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase DrainageStatusRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class DrainageStatusRepository extends Repository
{
    /**
     * Constructor de DrainageStatusRepository.
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
        return DrainageStatus::class;
    }

    /**
     * Actualizar en la BD la información de un estado de drenaje.
     *
     * @param array $data
     * @param DrainageStatus $entity
     *
     * @return DrainageStatus|null
     */
    public function updateFromArray(array $data, DrainageStatus $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo estado de drenaje.
     *
     * @param array $data
     *
     * @return DrainageStatus|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}