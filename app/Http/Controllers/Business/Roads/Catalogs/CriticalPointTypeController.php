<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\CriticalPointTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase CriticalPointTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class CriticalPointTypeController extends Controller
{

    /**
     * @var CriticalPointTypeProcess
     */
    protected $criticalPointTypeProcess;

    /**
     * Constructor CriticalPointTypeController.
     * @param CriticalPointTypeProcess $criticalPointTypeProcess
     */
    public function __construct(
        CriticalPointTypeProcess $criticalPointTypeProcess
    )
    {
        $this->criticalPointTypeProcess = $criticalPointTypeProcess;
    }

    /**
     * Mostrar vista de listado de punto crítico.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.critical_point_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un punto crítico.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->criticalPointTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de punto crítico.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.critical_point_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo punto crítico.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->criticalPointTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.critical_point_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('critical_point.messages.success.critical_point_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
