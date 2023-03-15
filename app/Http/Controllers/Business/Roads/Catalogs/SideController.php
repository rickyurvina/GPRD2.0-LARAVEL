<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SideProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SideController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SideController extends Controller
{

    /**
     * @var SideProcess
     */
    protected $sideProcess;

    /**
     * Constructor SideController.
     * @param SideProcess $sideProcess
     */
    public function __construct(
        SideProcess $sideProcess
    )
    {
        $this->sideProcess = $sideProcess;
    }

    /**
     * Mostrar vista de listado de lados
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.side.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un lado.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->sideProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de lado.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.side.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo lado.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->sideProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.side.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('ditch.messages.success.side_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
