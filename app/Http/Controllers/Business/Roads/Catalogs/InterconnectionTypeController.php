<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\InterconnectionTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase InterconnectionTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class InterconnectionTypeController extends Controller
{

    /**
     * @var InterconnectionTypeProcess
     */
    protected $interconnectionTypeProcess;

    /**
     * Constructor InterconnectionTypeController.
     * @param InterconnectionTypeProcess $interconnectionTypeProcess
     */
    public function __construct(
        InterconnectionTypeProcess $interconnectionTypeProcess
    )
    {
        $this->interconnectionTypeProcess = $interconnectionTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de interconexiones
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.interconnection_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de interconexión.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->interconnectionTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de interconexiones.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.interconnection_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de interconexión.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->interconnectionTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.interconnection_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('general_characteristics_of_track.messages.success.interconnection_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
