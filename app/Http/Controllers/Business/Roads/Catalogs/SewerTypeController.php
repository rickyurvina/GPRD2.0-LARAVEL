<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SewerTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SewerTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SewerTypeController extends Controller
{

    /**
     * @var SewerTypeProcess
     */
    protected $sewerTypeProcess;

    /**
     * Constructor SewerTypeController.
     * @param SewerTypeProcess $sewerTypeProcess
     */
    public function __construct(
        SewerTypeProcess $sewerTypeProcess
    )
    {
        $this->sewerTypeProcess = $sewerTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de alcantarillas
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.sewer_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de alcantarilla.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->sewerTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de alcantarillas.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.sewer_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de alcantarilla.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->sewerTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.sewer_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('sewer.messages.success.type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
