<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\TypeConservationNeedProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase TypeConservationNeedController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class TypeConservationNeedController extends Controller
{

    /**
     * @var TypeConservationNeedProcess
     */
    protected $typeConservationNeedProcess;

    /**
     * Constructor TypeConservationNeedController.
     * @param TypeConservationNeedProcess $typeConservationNeedProcess
     */
    public function __construct(
        TypeConservationNeedProcess $typeConservationNeedProcess
    )
    {
        $this->typeConservationNeedProcess = $typeConservationNeedProcess;
    }

    /**
     * Mostrar vista de listado de tipos de necesidad de conservación.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.type_conservation_need.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de necesidad de conservación.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->typeConservationNeedProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de necesidad de conservación.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.type_conservation_need.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de necesidad de conservación.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->typeConservationNeedProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.type_conservation_need.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('conservation_needs.messages.success.type_conservation_need_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
