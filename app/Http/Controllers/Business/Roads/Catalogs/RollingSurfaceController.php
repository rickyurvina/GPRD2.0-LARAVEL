<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\RollingSurfaceProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase RollingSurfaceController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class RollingSurfaceController extends Controller
{

    /**
     * @var RollingSurfaceProcess
     */
    protected $rollingSurfaceProcess;

    /**
     * Constructor RollingSurfaceController.
     * @param RollingSurfaceProcess $rollingSurfaceProcess
     */
    public function __construct(
        RollingSurfaceProcess $rollingSurfaceProcess
    )
    {
        $this->rollingSurfaceProcess = $rollingSurfaceProcess;
    }

    /**
     * Mostrar vista de listado de superficies de rodaduras.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.rolling_surface.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de una superficie de rodadura.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->rollingSurfaceProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de superficie de rodadura.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.rolling_surface.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nueva superficie de rodadura.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->rollingSurfaceProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.rolling_surface.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.rolling_surface_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
