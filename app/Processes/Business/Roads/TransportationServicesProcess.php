<?php

namespace App\Processes\Business\Roads;

use App\Models\Business\Roads\TransportationServices;
use App\Models\Business\Roads\TypeServiceAssociated;
use App\Repositories\Repository\Business\Roads\TransportationServicesRepository;
use App\Repositories\Repository\Business\Roads\GeneralCharacteristicsOfTrackRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase TransportationServicesProcess
 * @package App\Processes\Business\Roads
 */
class TransportationServicesProcess
{
    /**
     * @var TransportationServicesRepository
     */
    protected $transportationServicesRepository;

    /**
     * @var GeneralCharacteristicsOfTrackRepository
     */
    protected $generalCharacteristicsOfTrackRepository;

    /**
     * Constructor de TransportationServicesProcess.
     *
     * @param TransportationServicesRepository $transportationServicesRepository
     * @param GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
     */
    public function __construct(
        TransportationServicesRepository $transportationServicesRepository,
        GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
    )
    {
        $this->transportationServicesRepository = $transportationServicesRepository;
        $this->generalCharacteristicsOfTrackRepository = $generalCharacteristicsOfTrackRepository;
    }

    /**
     * Cargar información de los servicios de transporte de la vía.
     *
     * @param string $code
     *
     * @return mixed
     * @throws Exception
     */
    public function data(string $code)
    {
        $user = currentUser();
        $actions = [];
        if ($user->can('show.transportation_services.inventory_roads')) {
            $actions['search'] = [
                'route' => 'show.transportation_services.inventory_roads',
                'tooltip' => trans('transportation_services.labels.details')
            ];
        }
        if ($user->can('edit.transportation_services.inventory_roads')) {
            $actions['edit'] = [
                'route' => 'edit.transportation_services.inventory_roads',
                'tooltip' => trans('transportation_services.labels.update')
            ];
        }
        $dataTable = DataTables::of($this->transportationServicesRepository->findByCodeDataTable($code))
            ->setRowId('gid')
            ->addColumn('actions', function (TransportationServices $entity) use ($actions) {
                return view('layout.partial.actions_tooltip', [
                    'entity' => $entity,
                    'actions' => $actions
                ]);
            })
            ->rawColumns(['actions'])
            ->make(true);
        return $dataTable;
    }

    /**
     * Almacenar nueva información de servicio de transporte para una vía.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->transportationServicesRepository->createFromArray($request->all());
        if (!$entity) {
            throw new Exception(trans('transportation_services.messages.errors.create'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'transportation_services' => true
        ];
    }

    /**
     * Retornar data necesaria para mostrar la información de un servicio de transporte de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function show(string $gid)
    {
        $entity = $this->transportationServicesRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('transportation_services.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de creación de un servicio de transporte de una vía.
     *
     * @param string $code
     *
     * @return array
     */
    public function create(string $code)
    {
        $typeServicesAssociated = TypeServiceAssociated::all();
        return [
            'code' => $code,
            'typeServicesAssociated' => $typeServicesAssociated
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de edición de un servicio de transporte de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function edit(string $gid)
    {
        $typeServicesAssociated = TypeServiceAssociated::all();
        $entity = $this->transportationServicesRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('transportation_services.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity,
            'typeServicesAssociated' => $typeServicesAssociated
        ];
    }

    /**
     * Actualizar la información de un servicio de transporte de una vía.
     *
     * @param Request $request
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function update(Request $request, string $gid)
    {
        $entity = $this->transportationServicesRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('transportation_services.messages.exceptions.not_found'), 1000);
        }
        $entity = $this->transportationServicesRepository->updateFromArray($request->all(), $entity);
        if (!$entity) {
            throw new Exception(trans('transportation_services.messages.errors.update'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'transportation_services' => true
        ];
    }
}