<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\DrainageType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase DrainageTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class DrainageTypeRepository extends Repository
{
    /**
     * Constructor de DrainageTypeRepository.
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
        return DrainageType::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de drenaje.
     *
     * @param array $data
     * @param DrainageType $entity
     *
     * @return DrainageType|null
     */
    public function updateFromArray(array $data, DrainageType $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de drenaje.
     *
     * @param array $data
     *
     * @return DrainageType|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}