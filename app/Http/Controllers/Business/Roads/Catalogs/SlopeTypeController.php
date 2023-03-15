<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SlopeTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SlopeTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SlopeTypeController extends Controller
{

    /**
     * @var SlopeTypeProcess
     */
    protected $slopeTypeProcess;

    /**
     * Constructor SlopeTypeController.
     * @param SlopeTypeProcess $slopeTypeProcess
     */
    public function __construct(
        SlopeTypeProcess $slopeTypeProcess
    )
    {
        $this->slopeTypeProcess = $slopeTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de talud
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.slope_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de talud.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->slopeTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de talud.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.slope_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de talud.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->slopeTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.slope_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('slope.messages.success.slope_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
