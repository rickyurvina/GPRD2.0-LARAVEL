<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\StatusProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase StatusController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class StatusController extends Controller
{

    /**
     * @var StatusProcess
     */
    protected $statusProcess;

    /**
     * Constructor StatusController.
     * @param StatusProcess $statusProcess
     */
    public function __construct(
        StatusProcess $statusProcess
    )
    {
        $this->statusProcess = $statusProcess;
    }

    /**
     * Mostrar vista de listado de estados.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.status.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un estado.
     *
     * @return string
     */
    public function data()
    {
        try {
            return $this->statusProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de estado.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.status.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo estado.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->statusProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.status.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('general_characteristics_of_track.messages.success.status_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
