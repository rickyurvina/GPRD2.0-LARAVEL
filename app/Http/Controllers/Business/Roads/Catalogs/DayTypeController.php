<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\DayTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase DayTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class DayTypeController extends Controller
{

    /**
     * @var DayTypeProcess
     */
    protected $dayTypeProcess;

    /**
     * Constructor DayTypeController.
     * @param DayTypeProcess $dayTypeProcess
     */
    public function __construct(
        DayTypeProcess $dayTypeProcess
    )
    {
        $this->dayTypeProcess = $dayTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de días.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.day_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de día.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->dayTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de día.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.day_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de día.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->dayTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.day_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('traffic.messages.success.day_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
