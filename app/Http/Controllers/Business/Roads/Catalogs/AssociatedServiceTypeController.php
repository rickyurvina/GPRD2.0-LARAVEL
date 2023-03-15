<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\AssociatedServiceTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase AssociatedServiceTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class AssociatedServiceTypeController extends Controller
{

    /**
     * @var AssociatedServiceTypeProcess
     */
    protected $associatedServiceTypeProcess;

    /**
     * Constructor AssociatedServiceTypeController.
     * @param AssociatedServiceTypeProcess $associatedServiceTypeProcess
     */
    public function __construct(
        AssociatedServiceTypeProcess $associatedServiceTypeProcess
    )
    {
        $this->associatedServiceTypeProcess = $associatedServiceTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de servicios asociados
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.associated_service_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de servicio asociado.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->associatedServiceTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de servicio asociado.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.associated_service_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de servicio asociado.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->associatedServiceTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.associated_service_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('transportation_services.messages.success.associated_service_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
