<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\LanesProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase LanesController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class LanesController extends Controller
{

    /**
     * @var LanesProcess
     */
    protected $lanesProcess;

    /**
     * Constructor LanesController.
     * @param LanesProcess $lanesProcess
     */
    public function __construct(
        LanesProcess $lanesProcess
    )
    {
        $this->lanesProcess = $lanesProcess;
    }

    /**
     * Mostrar vista de listado de carriles
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.lanes.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de los carriles.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->lanesProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }
}
