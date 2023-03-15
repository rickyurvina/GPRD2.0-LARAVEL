<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\Source;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase SourceRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class SourceRepository extends Repository
{
    /**
     * Constructor de SourceRepository.
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
        return Source::class;
    }

    /**
     * Actualizar en la BD la información de una fuente.
     *
     * @param array $data
     * @param Source $entity
     *
     * @return Source|null
     */
    public function updateFromArray(array $data, Source $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nueva fuente.
     *
     * @param array $data
     *
     * @return Source|null
     */
    public function createFromArray(array $data)
    {
        $entity = new $this->model;
        $entity = $entity->create($data);

        return $entity->fresh();
    }
}