<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\DitchTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase DitchTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class DitchTypeController extends Controller
{

    /**
     * @var DitchTypeProcess
     */
    protected $ditchTypeProcess;

    /**
     * Constructor DitchTypeController.
     * @param DitchTypeProcess $ditchTypeProcess
     */
    public function __construct(
        DitchTypeProcess $ditchTypeProcess
    )
    {
        $this->ditchTypeProcess = $ditchTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de cunetas
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.ditch_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de cuneta.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->ditchTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de cuneta.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.ditch_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de cuneta.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->ditchTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.ditch_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('ditch.messages.success.ditch_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
