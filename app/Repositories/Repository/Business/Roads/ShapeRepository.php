<?php

namespace App\Repositories\Repository\Business\Roads;

use App\Models\Business\Roads\Shape;
use App\Models\System\File;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use DB;
use Exception;
use Illuminate\Container\Container as App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

/**
 * Clase ShapeRepository
 * @package App\Repositories\Repository\Business\Roads
 */
class ShapeRepository extends Repository
{
    /**
     * Constructor de ShapeRepository.
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
        return Shape::class;
    }

    /**
     * Obtener de la BD un shape por gid.
     *
     * @param int $gid
     *
     * @return mixed
     */
    public function findById(int $gid)
    {
        return $this->model->where('gid', $gid)->first();
    }

    /**
     * Obtener de la BD todos los shapes de la vía.
     *
     * @param string $code
     *
     * @return mixed
     */
    public function findByCodeDataTable(string $code)
    {
        return $this->model->where('codigo', $code);
    }

    /**
     * Verificar si existe un shape principal.
     *
     * @param string $code
     *
     * @return mixed
     */
    public function shapeCode(string $code)
    {
        return $this->model->where(['codigo' => $code, 'is_primary' => Shape::IS_PRIMARY])->select('is_primary')->get();
    }

    /**
     * Obtener de la BD todos los shapes de la vía por codigo.
     *
     * @param string $code
     *
     * @return mixed
     */
    public function findByCode(string $code)
    {
        return $this->model
            ->where('codigo', $code)
            ->where('is_primary', '<>', Shape::IS_PRIMARY)
            ->where(function ($query) {
                $query->where('extension', Shape::EXTENSION_DBF)
                    ->orWhere('extension', Shape::EXTENSION_SHP);
            })
            ->select(DB::raw('CONCAT("' . $_SERVER["APP_URL"] . env('INVENTORY_ROAD_PATH') . '",path) as shape'), 'extension')
            ->get();
    }

    /**
     * Obtener de la BD todos los shapes de la vía por codigo.
     *
     * @param string $code
     *
     * @return mixed
     */
    public function shapesBackground(string $code)
    {
        return $this->model
            ->where('codigo', $code)
            ->where('is_primary', Shape::IS_PRIMARY)
            ->select(DB::raw('CONCAT("' . $_SERVER["APP_URL"] . env('INVENTORY_ROAD_PATH') . '",path) as shape'), 'extension')
            ->first();
    }

    /**
     * Actualizar en la BD la información de un shape.
     *
     * @param array $data
     * @param Shape $entity
     *
     * @return Shape|null
     */
    public function updateFromArray(array $data, Shape $entity)
    {
        if (isset($data['shape']) && $data['shape']) {
            if (Storage::disk('inventory_roads')->exists($entity->path)) {
                Storage::disk('inventory_roads')->delete($entity->path);
            }
            $data['name'] = $data['shape']->getClientOriginalName();
            $data['extension'] = $data['shape']->getClientOriginalExtension();
            $fileName = $data['codigo'] . '_' . $data['shape']->getClientOriginalName();
            $data['shape']->storeAs($data['codigo'] . env('SHAPE_PATH'), $fileName, 'inventory_roads');
            $data['path'] = $data['codigo'] . env('SHAPE_PATH') . $fileName;
        } else {
            unset($data['shape']);
        }
        $entity->fill($data);
        $entity->save();
        return $entity->fresh();
    }

    /**
     * Almacenar en la BD un nuevo shape.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function createFromArray(array $data)
    {
        $shapes = $data['shape'];
        $message = trans('main_shape.messages.success.created');
        $type_message = 'success';
        $enable = 1;

        foreach ($data['shape'] as $file) {
            if (strtolower($file->getClientOriginalExtension()) !== File::SHAPE_FILE_EXTENSION) {
                $message = trans('shape.messages.errors.only_shp');
                $type_message = 'danger';
                $enable = 0;
                break;
            }
        }

        if ($enable) {
            try {
                foreach ($shapes as $shape) {
                    $entity = new $this->model;
                    $shapeData['codigo'] = $data['codigo'];
                    $shapeData['name'] = $shape->getClientOriginalName();
                    $shapeData['extension'] = $shape->getClientOriginalExtension();
                    $fileName = $data['codigo'] . '_' . $shape->getClientOriginalName();
                    $shape->storeAs($data['codigo'] . env('SHAPE_PATH'), $fileName, 'inventory_roads');
                    $shapeData['path'] = $data['codigo'] . env('SHAPE_PATH') . $fileName;
                    $entity->create($shapeData);
                }
            } catch (Exception $e) {
                return [false];
            }

            return [true, $message, $type_message];
        }

        return [false, $message, $type_message];

    }

    /**
     * Eliminar de la BD un shape.
     *
     * @param Model $entity
     *
     * @return bool|mixed|null
     * @throws Exception
     */
    public function delete(Model $entity)
    {
        if (Storage::disk('inventory_roads')->exists($entity->path)) {
            Storage::disk('inventory_roads')->delete($entity->path);
        }
        return $entity->delete();
    }
}