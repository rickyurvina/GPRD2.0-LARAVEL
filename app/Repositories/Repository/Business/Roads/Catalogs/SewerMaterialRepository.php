<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\SewerMaterial;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase SewerMaterialRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class SewerMaterialRepository extends Repository
{
    /**
     * Constructor de SewerMaterialRepository.
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
        return SewerMaterial::class;
    }

    /**
     * Actualizar en la BD la información de un material de alcantarilla.
     *
     * @param array $data
     * @param SewerMaterial $entity
     *
     * @return SewerMaterial|null
     */
    public function updateFromArray(array $data, SewerMaterial $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo material de alcantarilla.
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