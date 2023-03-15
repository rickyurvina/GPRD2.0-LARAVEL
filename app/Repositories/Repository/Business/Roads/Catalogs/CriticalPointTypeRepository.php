<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\CriticalPointType;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase CriticalPointTypeRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class CriticalPointTypeRepository extends Repository
{
    /**
     * Constructor de CriticalPointTypeRepository.
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
        return CriticalPointType::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de punto crítico.
     *
     * @param array $data
     * @param CriticalPointType $entity
     *
     * @return CriticalPointType|null
     */
    public function updateFromArray(array $data, CriticalPointType $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de punto crítico.
     *
     * @param array $data
     *
     * @return CriticalPointType|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}