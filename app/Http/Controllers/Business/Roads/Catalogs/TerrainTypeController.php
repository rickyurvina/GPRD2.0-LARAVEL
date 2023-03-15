<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\TerrainTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase TerrainTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class TerrainTypeController extends Controller
{

    /**
     * @var TerrainTypeProcess
     */
    protected $terrainTypeProcess;

    /**
     * Constructor TerrainTypeController.
     * @param TerrainTypeProcess $terrainTypeProcess
     */
    public function __construct(
        TerrainTypeProcess $terrainTypeProcess
    )
    {
        $this->terrainTypeProcess = $terrainTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de terreno
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.terrain_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de los tipos de terreno.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->terrainTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipos de terreno.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.terrain_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de terreno.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->terrainTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.terrain_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('characteristics_of_track.messages.success.terrain_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
