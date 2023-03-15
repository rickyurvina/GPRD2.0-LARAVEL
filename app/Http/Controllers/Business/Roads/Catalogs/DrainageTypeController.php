<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\DrainageTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase DrainageTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class DrainageTypeController extends Controller
{

    /**
     * @var DrainageTypeProcess
     */
    protected $drainageTypeProcess;

    /**
     * Constructor DrainageTypeController.
     * @param DrainageTypeProcess $drainageTypeProcess
     */
    public function __construct(
        DrainageTypeProcess $drainageTypeProcess
    )
    {
        $this->drainageTypeProcess = $drainageTypeProcess;
    }

    /**
     * Mostrar vista de listado de los tipos de drenaje.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.drainage_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de drenaje.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->drainageTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de drenaje.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.drainage_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de drenaje.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->drainageTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.drainage_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.drainage_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
