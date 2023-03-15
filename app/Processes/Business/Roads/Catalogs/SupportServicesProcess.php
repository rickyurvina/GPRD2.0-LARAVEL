<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Models\Business\Roads\Catalogs\SupportServices;
use App\Repositories\Repository\Business\Roads\Catalogs\SupportServicesRepository;
use Intervention\Image\Facades\Image;
use Nexmo\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SupportServicesProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SupportServicesProcess
{
    /**
     * @var SupportServicesRepository
     */
    protected $supportServicesRepository;

    /**
     * Constructor de SupportServicesProcess.
     *
     * @param SupportServicesRepository $supportServicesRepository
     */
    public function __construct(
        SupportServicesRepository $supportServicesRepository
    ) {
        $this->supportServicesRepository = $supportServicesRepository;
    }

    /**
     * Cargar información del servicio de apoyo.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $supportServices = $this->supportServicesRepository->all();

        $dataTable = DataTables::of($supportServices)
            ->setRowId('id')
            ->editColumn('imagen', function (SupportServices $entity) {

                $urlImage = route('download_image.index.support_services.inventory_roads_catalogs', ['gid' => $entity->id]);

                if (!isset($entity->imagen)) {
                    return '<i class="fa fa-ban red"></i>';
                } else {
                    return '<a class="btn btn-xs btn-primary" role="button" href="' . $urlImage .
                        '" data-toggle="tooltip" data-placement="top" data-original-title="' .
                        trans('social_information.labels.download_image') . '"><i class="fa fa-download"></i></a>';
                }
            })
            ->rawColumns(['imagen'])
            ->make(true);

        return $dataTable;
    }

    /**
     * Descargar la imagen de un servicio de apoyo.
     *
     * @param int $gid
     *
     * @return BinaryFileResponse
     * @throws Exception
     */
    public function downloadImage(int $gid)
    {
        $entity = $this->supportServicesRepository->findBy('id', $gid);

        if (!$entity) {
            throw new Exception(trans('social_information.messages.errors.download_support_service_image'), 1000);
        }

        $image_path = env('INVENTORY_ROADS_CATALOGS') . 'support_services/' . $entity->imagen;

        return response()->download($image_path);
    }

    /**
     * Almacenar nuevo servicio de apoyo.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (isset($data['imagen'])) {
            $extension = $request->imagen->extension();
            $image_name = 'apoyo_' . $data['gid'] . '.' . $extension;
            $data['imagen'] = $image_name;
        }

        $entity = $this->supportServicesRepository->createFromArray($data);

        if (!$entity) {
            throw new Exception(trans('social_information.messages.errors.create_support_services'), 1000);
        }

        // upload file
        if (isset($entity->imagen)) {
            $request->imagen->storeAs('support_services', $data['imagen'], 'inventory_roads_catalogs');
        }

        return $entity;
    }
}