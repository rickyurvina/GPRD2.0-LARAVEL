<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\MinesMaterialProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase MinesMaterialController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class MinesMaterialController extends Controller
{

    /**
     * @var MinesMaterialProcess
     */
    protected $minesMaterialProcess;

    /**
     * Constructor MinesMaterialController.
     * @param MinesMaterialProcess $minesMaterialProcess
     */
    public function __construct(
        MinesMaterialProcess $minesMaterialProcess
    )
    {
        $this->minesMaterialProcess = $minesMaterialProcess;
    }

    /**
     * Mostrar vista de listado de materiales de minas.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.mines_material.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un material de minas.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->minesMaterialProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de material de minas.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.mines_material.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo material de minas.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->minesMaterialProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.mines_material.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('mines.messages.success.mines_material_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
