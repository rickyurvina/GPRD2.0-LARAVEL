<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\SupportServices;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase SupportServicesRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class SupportServicesRepository extends Repository
{
    /**
     * Constructor de SupportServicesRepository.
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
        return SupportServices::class;
    }

    /**
     * Actualizar en la BD la información de un servicio de apoyo.
     *
     * @param array $data
     * @param SupportServices $entity
     *
     * @return SupportServices|null
     */
    public function updateFromArray(array $data, SupportServices $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo servicio de apoyo.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity;
    }
}