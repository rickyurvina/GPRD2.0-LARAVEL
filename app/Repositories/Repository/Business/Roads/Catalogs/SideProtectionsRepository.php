<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\SideProtections;
use App\Models\Business\Roads\Catalogs\Status;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase SideProtectionsRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class SideProtectionsRepository extends Repository
{
    /**
     * Constructor de SideProtectionsRepository.
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
        return SideProtections::class;
    }

    /**
     * Actualizar en la BD la información de una protección lateral.
     *
     * @param array $data
     * @param SideProtections $entity
     *
     * @return SideProtections|null
     */
    public function updateFromArray(array $data, SideProtections $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD una nueva protección lateral.
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