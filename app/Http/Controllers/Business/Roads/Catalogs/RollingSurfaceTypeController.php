<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\RollingSurfaceTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase RollingSurfaceTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class RollingSurfaceTypeController extends Controller
{

    /**
     * @var RollingSurfaceTypeProcess
     */
    protected $rollingSurfaceTypeProcess;

    /**
     * Constructor RollingSurfaceTypeController.
     * @param RollingSurfaceTypeProcess $rollingSurfaceTypeProcess
     */
    public function __construct(
        RollingSurfaceTypeProcess $rollingSurfaceTypeProcess
    )
    {
        $this->rollingSurfaceTypeProcess = $rollingSurfaceTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de superficies de rodaduras.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.rolling_surface_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de superficie de rodadura.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->rollingSurfaceTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }
}
