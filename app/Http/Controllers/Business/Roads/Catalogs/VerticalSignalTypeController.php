<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\VerticalSignalTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase VerticalSignalTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class VerticalSignalTypeController extends Controller
{

    /**
     * @var VerticalSignalTypeProcess
     */
    protected $verticalSignalTypeProcess;

    /**
     * Constructor VerticalSignalTypeController.
     * @param VerticalSignalTypeProcess $verticalSignalTypeProcess
     */
    public function __construct(
        VerticalSignalTypeProcess $verticalSignalTypeProcess
    )
    {
        $this->verticalSignalTypeProcess = $verticalSignalTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de señal vertical
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.vertical_signal_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de señal vertical.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->verticalSignalTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de señal vertical.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.vertical_signal_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de señal vertical.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->verticalSignalTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.vertical_signal_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('signal_vertical.messages.success.vertical_signal_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
