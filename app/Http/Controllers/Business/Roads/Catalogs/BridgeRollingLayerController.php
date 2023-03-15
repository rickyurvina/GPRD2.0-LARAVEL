<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\BridgeRollingLayerProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase BridgeRollingLayerController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class BridgeRollingLayerController extends Controller
{

    /**
     * @var BridgeRollingLayerProcess
     */
    protected $bridgeRollingLayerProcess;

    /**
     * Constructor BridgeRollingLayerController.
     * @param BridgeRollingLayerProcess $bridgeRollingLayerProcess
     */
    public function __construct(
        BridgeRollingLayerProcess $bridgeRollingLayerProcess
    )
    {
        $this->bridgeRollingLayerProcess = $bridgeRollingLayerProcess;
    }

    /**
     * Mostrar vista de listado de capa rodadura puente
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.bridge_rolling_layer.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de una capa rodadura puente.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->bridgeRollingLayerProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de capa rodadura puente.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.bridge_rolling_layer.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nueva capa rodadura puente.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->bridgeRollingLayerProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.bridge_rolling_layer.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('bridge.messages.success.bridge_rolling_layer_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
