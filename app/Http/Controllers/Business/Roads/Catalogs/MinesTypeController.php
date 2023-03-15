<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\MinesTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase MinesTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class MinesTypeController extends Controller
{

    /**
     * @var MinesTypeProcess
     */
    protected $minesTypeProcess;

    /**
     * Constructor MinesTypeController.
     * @param MinesTypeProcess $minesTypeProcess
     */
    public function __construct(
        MinesTypeProcess $minesTypeProcess
    )
    {
        $this->minesTypeProcess = $minesTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipos de minas.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.mines_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de minas.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->minesTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de minas.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.mines_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de minas.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->minesTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.mines_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('mines.messages.success.mines_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
