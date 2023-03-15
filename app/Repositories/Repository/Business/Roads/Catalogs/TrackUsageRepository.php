<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\TrackUsage;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase TrackUsageRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class TrackUsageRepository extends Repository
{
    /**
     * Constructor de TrackUsageRepository.
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
        return TrackUsage::class;
    }

    /**
     * Actualizar en la BD la información de un uso vía.
     *
     * @param array $data
     * @param TrackUsage $entity
     *
     * @return TrackUsage|null
     */
    public function updateFromArray(array $data, TrackUsage $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo uso vía.
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