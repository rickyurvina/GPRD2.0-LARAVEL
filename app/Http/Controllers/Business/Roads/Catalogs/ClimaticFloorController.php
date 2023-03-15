<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\ClimaticFloorProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase ClimaticFloorController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class ClimaticFloorController extends Controller
{

    /**
     * @var ClimaticFloorProcess
     */
    protected $climaticFloorProcess;

    /**
     * Constructor ClimaticFloorController.
     * @param ClimaticFloorProcess $climaticFloorProcess
     */
    public function __construct(
        ClimaticFloorProcess $climaticFloorProcess
    )
    {
        $this->climaticFloorProcess = $climaticFloorProcess;
    }

    /**
     * Mostrar vista de listado de pisos climáticos.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.climatic_floor.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un piso climático.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->climaticFloorProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de piso climático.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.climatic_floor.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo piso climático.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->climaticFloorProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.climatic_floor.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.climatic_floor_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
