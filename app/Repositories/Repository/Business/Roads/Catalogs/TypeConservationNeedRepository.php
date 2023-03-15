<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\TypeConservationNeed;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase TypeConservationNeedRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class TypeConservationNeedRepository extends Repository
{
    /**
     * Constructor de TypeConservationNeedRepository.
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
        return TypeConservationNeed::class;
    }

    /**
     * Actualizar en la BD la información de un tipo de necesidad de conservación.
     *
     * @param array $data
     * @param TypeConservationNeed $entity
     *
     * @return TypeConservationNeed|null
     */
    public function updateFromArray(array $data, TypeConservationNeed $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo tipo de necesidad de conservación.
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