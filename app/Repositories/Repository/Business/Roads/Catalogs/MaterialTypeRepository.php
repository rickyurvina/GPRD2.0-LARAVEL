<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\MaterialType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase MaterialTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class MaterialTypeRepository extends Repository
{
    /**
     * Constructor de MaterialTypeRepository.
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
        return MaterialType::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de material.
     *
     * @param array $data
     * @param MaterialType $entity
     *
     * @return MaterialType|null
     */
    public function updateFromArray(array $data, MaterialType $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de material.
     *
     * @param array $data
     *
     * @return MaterialType|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}