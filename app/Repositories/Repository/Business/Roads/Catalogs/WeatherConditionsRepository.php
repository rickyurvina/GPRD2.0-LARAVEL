<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\WeatherConditions;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase WeatherConditionsRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class WeatherConditionsRepository extends Repository
{
    /**
     * Constructor de WeatherConditionsRepository.
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
        return WeatherConditions::class;
    }

    /**
     * Actualizar en la BD la información de una condición climática.
     *
     * @param array $data
     * @param WeatherConditions $entity
     *
     * @return WeatherConditions|null
     */
    public function updateFromArray(array $data, WeatherConditions $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD una nueva condición climática.
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