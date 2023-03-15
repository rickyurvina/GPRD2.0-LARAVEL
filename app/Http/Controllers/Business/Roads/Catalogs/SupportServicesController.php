<?php

namespace App\Http\Controllers\Business\Roads\Catalogs;

use App\Processes\Business\Roads\Catalogs\SupportServicesProcess;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

/**
 * Clase SupportServicesController
 * @package App\Http\Controllers\Business\Roads\Catalogs
 */
class SupportServicesController extends Controller
{

    /**
     * @var SupportServicesProcess
     */
    protected $supportServicesProcess;

    /**
     * Constructor SupportServicesController.
     * @param SupportServicesProcess $supportServicesProcess
     */
    public function __construct(
        SupportServicesProcess $supportServicesProcess
    )
    {
        $this->supportServicesProcess = $supportServicesProcess;
    }

    /**
     * Mostrar vista de listado de servicios de apoyo.
     *
     * @return JsonResponse
     */
    public function index()
    {
        try {
            $response['view'] = view('business.roads.catalogs.support_services.index')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para cargar información de un servicio de apoyo.
     *
     * @return mixed|string
     */
    public function data()
    {
        try {
            return $this->supportServicesProcess->data();
        } catch (Throwable $e) {
            return datatableEmptyResponse($e, $e);
        }
    }

    /**
     * Llamada al proceso para descargar la imagen del servicio de apoyo.
     *
     * @param int $gid
     *
     * @return mixed|BinaryFileResponse
     */
    public function downloadImage(int $gid)
    {
        try {
            return $this->supportServicesProcess->downloadImage($gid);
        } catch (Throwable $e) {
            return defaultCatchHandler($e);
        }
    }

    /**
     * Llamada al proceso para mostrar el formulario de creación de servicio de apoyo.
     *
     * @return JsonResponse
     */
    public function create()
    {
        try {
            $response['modal_st'] = view('business.roads.catalogs.support_services.create')->render();
        } catch (Throwable $e) {
            $response = defaultCatchHandler($e);
        }

        return response()->json($response);
    }

    /**
     * Llamada al proceso para almacenar nuevo servicio de apoyo.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $this->supportServicesProcess->store($request);

            $response = [
                'view' => view('business.roads.catalogs.support_services.index')->render(),
                'message' => [
                    'type' => 'success',
                    'text' => trans('social_information.messages.success.support_services_created')
                ]
            ];
        } catch (Throwable $e) {
            return response()->json(defaultCatchHandler($e));
        }

        return response()->json($response);
    }
}
