<?php

namespace App\Repositories\Repository\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\MinesMaterial;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase MinesMaterialRepository
 * @package App\Repositories\Repository\Business\Roads\Catalogs
 */
class MinesMaterialRepository extends Repository
{
    /**
     * Constructor de MinesMaterialRepository.
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
        return MinesMaterial::class;
    }

    /**
     * Actualizar en la BD la información de un material de minas.
     *
     * @param array $data
     * @param MinesMaterial $entity
     *
     * @return MinesMaterial|null
     */
    public function updateFromArray(array $data, MinesMaterial $entity)
    {
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo material de minas.
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