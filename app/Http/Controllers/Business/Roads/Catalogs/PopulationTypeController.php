<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\PopulationTypeProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase PopulationTypeController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class PopulationTypeController extends Controller
{

    /**
     * @var PopulationTypeProcess
     */
    protected $populationTypeProcess;

    /**
     * Constructor PopulationTypeController.
     * @param PopulationTypeProcess $populationTypeProcess
     */
    public function __construct(
        PopulationTypeProcess $populationTypeProcess
    )
    {
        $this->populationTypeProcess = $populationTypeProcess;
    }

    /**
     * Mostrar vista de listado de tipo de población
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.population_type.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un tipo de población
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->populationTypeProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de tipo de población
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.population_type.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo tipo de población
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->populationTypeProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.population_type.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('social_information.messages.success.population_type_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
