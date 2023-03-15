<?php

namespace App\Processes\Business\Roads;

use App\Models\Business\Roads\HorizontalSignal;
use App\Models\Business\Roads\State;
use App\Models\Business\Roads\Side;
use App\Models\Business\Roads\TypeHorizontalSignal;
use App\Repositories\Repository\Business\Roads\GeneralCharacteristicsOfTrackRepository;
use App\Repositories\Repository\Business\Roads\HorizontalSignalRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase HorizontalSignalProcess
 * @package App\Processes\Business\Roads
 */
class HorizontalSignalProcess
{
    /**
     * @var HorizontalSignalRepository
     */
    protected $horizontalSignalRepository;

    /**
     * @var GeneralCharacteristicsOfTrackRepository
     */
    protected $generalCharacteristicsOfTrackRepository;

    /**
     * Constructor de HorizontalSignalProcess.
     *
     * @param HorizontalSignalRepository $horizontalSignalRepository
     * @param GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
     */
    public function __construct(
        HorizontalSignalRepository $horizontalSignalRepository,
        GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
    )
    {
        $this->horizontalSignalRepository = $horizontalSignalRepository;
        $this->generalCharacteristicsOfTrackRepository = $generalCharacteristicsOfTrackRepository;
    }

    /**
     * Cargar información de las senalizaciones horizontales de una via.
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
        if ($user->can('show.signal_horizontal.inventory_roads')) {
            $actions['search'] = [
                'route' => 'show.signal_horizontal.inventory_roads',
                'tooltip' => trans('signal_horizontal.labels.details')
            ];
        }
        if ($user->can('edit.signal_horizontal.inventory_roads')) {
            $actions['edit'] = [
                'route' => 'edit.signal_horizontal.inventory_roads',
                'tooltip' => trans('signal_horizontal.labels.update')
            ];
        }
        $dataTable = DataTables::of($this->horizontalSignalRepository->findByCodeDataTable($code))
            ->setRowId('gid')
            ->addColumn('actions', function (HorizontalSignal $entity) use ($actions) {
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
     * Almacenar nueva senalización horizontal de la vía.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->horizontalSignalRepository->createFromArray($request->all());
        if (!$entity) {
            throw new Exception(trans('signal_horizontal.messages.errors.create'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'signal_horizontal' => true
        ];
    }

    /**
     * Retornar data necesaria para mostrar la información de una senalización horizontal.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function show(string $gid)
    {
        $entity = $this->horizontalSignalRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('signal_horizontal.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de edición de una senalización horizontal.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function edit(string $gid)
    {
        $states = State::all();
        $sides = Side::all();
        $typeHorizontalSignals = TypeHorizontalSignal::all();
        $entity = $this->horizontalSignalRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('signal_horizontal.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity,
            'states' => $states,
            'sides' => $sides,
            'typeHorizontalSignals' => $typeHorizontalSignals
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de creación de una senalización horizontal.
     *
     * @param string $code
     *
     * @return array
     */
    public function create(string $code)
    {
        $states = State::all();
        $sides = Side::all();
        $typeHorizontalSignals = TypeHorizontalSignal::all();
        return [
            'code' => $code,
            'states' => $states,
            'sides' => $sides,
            'typeHorizontalSignals' => $typeHorizontalSignals
        ];
    }

    /**
     * Actualizar la información de una senalización horizontal de la vía.
     *
     * @param Request $request
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function update(Request $request, string $gid)
    {
        $entity = $this->horizontalSignalRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('signal_horizontal.messages.exceptions.not_found'), 1000);
        }
        $entity = $this->horizontalSignalRepository->updateFromArray($request->all(), $entity);
        if (!$entity) {
            throw new Exception(trans('signal_horizontal.messages.errors.update'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'signal_horizontal' => true
        ];
    }
}