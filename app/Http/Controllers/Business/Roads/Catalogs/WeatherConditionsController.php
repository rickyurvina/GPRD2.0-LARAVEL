<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\WeatherConditionsProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase WeatherConditionsController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class WeatherConditionsController extends Controller
{

    /**
     * @var WeatherConditionsProcess
     */
    protected $weatherConditionsProcess;

    /**
     * Constructor WeatherConditionsController.
     * @param WeatherConditionsProcess $weatherConditionsProcess
     */
    public function __construct(
        WeatherConditionsProcess $weatherConditionsProcess
    )
    {
        $this->weatherConditionsProcess = $weatherConditionsProcess;
    }

    /**
     * Mostrar vista de listado de condiciones climáticas
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.weather_conditions.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de una condición climática.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->weatherConditionsProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de condición climática.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.weather_conditions.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nueva condición climática.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->weatherConditionsProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.weather_conditions.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('general_characteristics_of_track.messages.success.weather_condition_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
