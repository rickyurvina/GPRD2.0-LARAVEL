<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\AssociatedServiceType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase AssociatedServiceTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class AssociatedServiceTypeRepository extends Repository
{
    /**
     * Constructor de AssociatedServiceTypeRepository.
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
        return AssociatedServiceType::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de servicio asociado.
     *
     * @param array $data
     * @param AssociatedServiceType $entity
     *
     * @return AssociatedServiceType|null
     */
    public function updateFromArray(array $data, AssociatedServiceType $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de servicio asociado.
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