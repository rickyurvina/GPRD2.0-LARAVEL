<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\Status;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase StatusRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class StatusRepository extends Repository
{
    /**
     * Constructor de StatusRepository.
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
        return Status::class;
    }

    /**
     * Actualizar en la BD la información de un estado.
     *
     * @param array $data
     * @param Status $entity
     *
     * @return Status|null
     */
    public function updateFromArray(array $data, Status $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo estado.
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

    /**
     * Obtener de la BD una colección de todos los estados de la vía excepto 'SIN DETERMINAR'.
     *
     * @return mixed
     */
    public function listActive()
    {
        return $this->model->where('descripcion', '<>', Status::WITHOUT_DETERMINING)->get();
    }
}