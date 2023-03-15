<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SewerMaterialProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SewerMaterialController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SewerMaterialController extends Controller
{

    /**
     * @var SewerMaterialProcess
     */
    protected $sewerMaterialProcess;

    /**
     * Constructor SewerMaterialController.
     * @param SewerMaterialProcess $sewerMaterialProcess
     */
    public function __construct(
        SewerMaterialProcess $sewerMaterialProcess
    )
    {
        $this->sewerMaterialProcess = $sewerMaterialProcess;
    }

    /**
     * Mostrar vista de listado de materiales de alcantarillas
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.sewer_material.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un material de alcantarilla.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->sewerMaterialProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de materiales de alcantarillas.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.sewer_material.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo material de alcantarilla.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->sewerMaterialProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.sewer_material.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('sewer.messages.success.sewer_material_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
