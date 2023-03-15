<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\FirmTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase FirmTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class FirmTypeController extends Controller
{

    /**
     * @var FirmTypeProcess
     */
    protected $firmTypeProcess;

    /**
     * Constructor FirmTypeController.
     * @param FirmTypeProcess $firmTypeProcess
     */
    public function __construct(
        FirmTypeProcess $firmTypeProcess
    )
    {
        $this->firmTypeProcess = $firmTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo firme.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.firm_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo firme.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->firmTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo firme.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.firm_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo firme.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->firmTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.firm_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('hdm4.messages.success.firm_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
