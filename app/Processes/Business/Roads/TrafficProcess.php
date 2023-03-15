<?php

namespace App\Processes\Business\Roads;

use App\Models\Business\Roads\Traffic;
use App\Models\Business\Roads\TypeDay;
use App\Repositories\Repository\Business\Roads\TrafficRepository;
use App\Repositories\Repository\Business\Roads\GeneralCharacteristicsOfTrackRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase TrafficProcess
 * @package App\Processes\Business\Roads
 */
class TrafficProcess
{
    /**
     * @var TrafficRepository
     */
    protected $trafficRepository;

    /**
     * @var GeneralCharacteristicsOfTrackRepository
     */
    protected $generalCharacteristicsOfTrackRepository;

    /**
     * Constructor de TrafficProcess.
     *
     * @param TrafficRepository $trafficRepository
     * @param GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
     */
    public function __construct(
        TrafficRepository $trafficRepository,
        GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
    )
    {
        $this->trafficRepository = $trafficRepository;
        $this->generalCharacteristicsOfTrackRepository = $generalCharacteristicsOfTrackRepository;
    }

    /**
     * Cargar información del tráfico de una vía.
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
        if ($user->can('show.traffic.inventory_roads')) {
            $actions['search'] = [
                'route' => 'show.traffic.inventory_roads',
                'tooltip' => trans('traffic.labels.details')
            ];
        }
        if ($user->can('edit.traffic.inventory_roads')) {
            $actions['edit'] = [
                'route' => 'edit.traffic.inventory_roads',
                'tooltip' => trans('traffic.labels.update')
            ];
        }
        $dataTable = DataTables::of($this->trafficRepository->findByCodeDataTable($code))
            ->setRowId('gid')
            ->addColumn('actions', function (Traffic $entity) use ($actions) {
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
     * Almacenar nuevo tráfico para una vía.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['Total tráfico'] = intval($data['Numlivianos']) + intval($data['Numbuses']) + intval($data['Num2ejes']) + intval($data['Num3ejes']) + intval($data['Num4ejes']) +
            intval($data['Num5ejes']);
        $entity = $this->trafficRepository->createFromArray($data);
        if (!$entity) {
            throw new Exception(trans('traffic.messages.errors.create'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'traffic' => true
        ];
    }

    /**
     * Retornar data necesaria para mostrar la información del tráfico de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function show(string $gid)
    {
        $entity = $this->trafficRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('traffic.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de edición del tráfico de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function edit(string $gid)
    {
        $typeDays = TypeDay::all();
        $entity = $this->trafficRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('traffic.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity,
            'typeDays' => $typeDays
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de creación del tráfico de una vía.
     *
     * @param string $code
     *
     * @return array
     */
    public function create(string $code)
    {
        $typeDays = TypeDay::all();
        return [
            'code' => $code,
            'typeDays' => $typeDays
        ];
    }

    /**
     * Actualizar la información del tráfico de una vía.
     *
     * @param Request $request
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function update(Request $request, string $gid)
    {
        $entity = $this->trafficRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('traffic.messages.exceptions.not_found'), 1000);
        }
        $data = $request->all();
        $data['Total tráfico'] = intval($data['Numlivianos']) + intval($data['Numbuses']) + intval($data['Num2ejes']) + intval($data['Num3ejes']) + intval($data['Num4ejes']) +
            intval($data['Num5ejes']);

        $entity = $this->trafficRepository->updateFromArray($data, $entity);
        if (!$entity) {
            throw new Exception(trans('traffic.messages.errors.update'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'traffic' => true
        ];
    }
}