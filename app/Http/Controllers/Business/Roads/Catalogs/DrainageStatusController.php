<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\DrainageStatusProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase DrainageStatusController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class DrainageStatusController extends Controller
{

    /**
     * @var DrainageStatusProcess
     */
    protected $drainageStatusProcess;

    /**
     * Constructor DrainageStatusController.
     * @param DrainageStatusProcess $drainageStatusProcess
     */
    public function __construct(
        DrainageStatusProcess $drainageStatusProcess
    )
    {
        $this->drainageStatusProcess = $drainageStatusProcess;
    }

    /**
     * Mostrar vista de listado de los estados de drenaje.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.drainage_status.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un estado de drenaje.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->drainageStatusProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de estado de drenaje.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.drainage_status.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo estado de drenaje.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->drainageStatusProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.drainage_status.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.drainage_status_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
