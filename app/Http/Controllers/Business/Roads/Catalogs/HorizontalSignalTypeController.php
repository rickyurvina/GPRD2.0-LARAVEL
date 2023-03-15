<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\HorizontalSignalTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase HorizontalSignalTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class HorizontalSignalTypeController extends Controller
{

    /**
     * @var HorizontalSignalTypeProcess
     */
    protected $horizontalSignalTypeProcess;

    /**
     * Constructor HorizontalSignalTypeController.
     * @param HorizontalSignalTypeProcess $horizontalSignalTypeProcess
     */
    public function __construct(
        HorizontalSignalTypeProcess $horizontalSignalTypeProcess
    )
    {
        $this->horizontalSignalTypeProcess = $horizontalSignalTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de señal horizontal
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.horizontal_signal_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de señal horizontal.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->horizontalSignalTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de señal horizontal.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.horizontal_signal_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de señal horizontal.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->horizontalSignalTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.horizontal_signal_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('signal_horizontal.messages.success.horizontal_signal_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
