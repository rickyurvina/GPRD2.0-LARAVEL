<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\InterconnectionType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase InterconnectionTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class InterconnectionTypeRepository extends Repository
{
    /**
     * Constructor de InterconnectionTypeRepository.
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
        return InterconnectionType::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de interconexión.
     *
     * @param array $data
     * @param InterconnectionType $entity
     *
     * @return InterconnectionType|null
     */
    public function updateFromArray(array $data, InterconnectionType $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de interconexión.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}