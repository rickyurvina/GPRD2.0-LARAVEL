<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\ProductiveSectorProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase ProductiveSectorController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class ProductiveSectorController extends Controller
{

    /**
     * @var ProductiveSectorProcess
     */
    protected $productiveSectorProcess;

    /**
     * Constructor ProductiveSectorController.
     * @param ProductiveSectorProcess $productiveSectorProcess
     */
    public function __construct(
        ProductiveSectorProcess $productiveSectorProcess
    )
    {
        $this->productiveSectorProcess = $productiveSectorProcess;
    }

    /**
     * Mostrar vista de listado de los sectores productivos.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.productive_sector.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un sector productivo.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->productiveSectorProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de sector productivo.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.productive_sector.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo sector productivo.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->productiveSectorProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.productive_sector.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('production.messages.success.productive_sector_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
