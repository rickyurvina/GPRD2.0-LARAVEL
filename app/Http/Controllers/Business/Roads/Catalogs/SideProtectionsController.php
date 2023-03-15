<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SideProtectionsProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase SideProtectionsController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SideProtectionsController extends Controller
{

    /**
     * @var SideProtectionsProcess
     */
    protected $sideProtectionsProcess;

    /**
     * Constructor SideProtectionsController.
     * @param SideProtectionsProcess $sideProtectionsProcess
     */
    public function __construct(
        SideProtectionsProcess $sideProtectionsProcess
    )
    {
        $this->sideProtectionsProcess = $sideProtectionsProcess;
    }

    /**
     * Mostrar vista de listado de protecciones laterales
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.side_protections.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de las protecciones laterales.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->sideProtectionsProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de protecciones laterales.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.side_protections.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nueva protección lateral.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->sideProtectionsProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.side_protections.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('bridge.messages.success.side_protection_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
