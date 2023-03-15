<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\MaterialTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase MaterialTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class MaterialTypeController extends Controller
{

    /**
     * @var MaterialTypeProcess
     */
    protected $materialTypeProcess;

    /**
     * Constructor MaterialTypeController.
     * @param MaterialTypeProcess $materialTypeProcess
     */
    public function __construct(
        MaterialTypeProcess $materialTypeProcess
    )
    {
        $this->materialTypeProcess = $materialTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de materiales
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.material_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de material.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->materialTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de materiales.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.material_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de material.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->materialTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.material_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.material_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
