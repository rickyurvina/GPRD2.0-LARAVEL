<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SourceProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SourceController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SourceController extends Controller
{

    /**
     * @var SourceProcess
     */
    protected $sourceProcess;

    /**
     * Constructor SourceController.
     * @param SourceProcess $sourceProcess
     */
    public function __construct(
        SourceProcess $sourceProcess
    )
    {
        $this->sourceProcess = $sourceProcess;
    }

    /**
     * Mostrar vista de listado de fuentes.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.source.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de una fuente.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->sourceProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de fuente.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.source.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nueva fuente.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->sourceProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.source.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('mines.messages.success.source_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
