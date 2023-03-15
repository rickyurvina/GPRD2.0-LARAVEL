<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\TrackUsageProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

/**
 * Clase TrackUsageController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class TrackUsageController extends Controller
{

    /**
     * @var TrackUsageProcess
     */
    protected $trackUsageProcess;

    /**
     * Constructor TrackUsageController.
     * @param TrackUsageProcess $trackUsageProcess
     */
    public function __construct(
        TrackUsageProcess $trackUsageProcess
    )
    {
        $this->trackUsageProcess = $trackUsageProcess;
    }

    /**
     * Mostrar vista de listado de uso vía
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.track_usage.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de uso vía.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->trackUsageProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de uso vía.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.track_usage.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo uso vía.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->trackUsageProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.track_usage.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('characteristics_of_track.messages.success.track_usage_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
