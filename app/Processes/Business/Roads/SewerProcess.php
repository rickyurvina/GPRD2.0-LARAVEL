<?php

namespace App\Processes\Business\Roads;

use App\Models\Business\Roads\Sewer;
use App\Models\Business\Roads\State;
use App\Models\Business\Roads\Catalogs\SewerType;
use App\Models\Business\Roads\MaterialSewer;
use App\Repositories\Repository\Business\Roads\GeneralCharacteristicsOfTrackRepository;
use App\Repositories\Repository\Business\Roads\SewerRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SewerProcess
 * @package App\Processes\Business\Roads
 */
class SewerProcess
{
    /**
     * @var SewerRepository
     */
    protected $sewerRepository;

    /**
     * @var GeneralCharacteristicsOfTrackRepository
     */
    protected $generalCharacteristicsOfTrackRepository;

    /**
     * Constructor de SewerProcess.
     *
     * @param SewerRepository $sewerRepository
     * @param GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
     */
    public function __construct(
        SewerRepository $sewerRepository,
        GeneralCharacteristicsOfTrackRepository $generalCharacteristicsOfTrackRepository
    )
    {
        $this->sewerRepository = $sewerRepository;
        $this->generalCharacteristicsOfTrackRepository = $generalCharacteristicsOfTrackRepository;
    }

    /**
     * Cargar información de las alcantarillas de una vía.
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
        if ($user->can('show.sewer.inventory_roads')) {
            $actions['search'] = [
                'route' => 'show.sewer.inventory_roads',
                'tooltip' => trans('sewer.labels.details')
            ];
        }
        if ($user->can('edit.sewer.inventory_roads')) {
            $actions['edit'] = [
                'route' => 'edit.sewer.inventory_roads',
                'tooltip' => trans('sewer.labels.update')
            ];
        }
        $dataTable = DataTables::of($this->sewerRepository->findByCodeDataTable($code))
            ->setRowId('gid')
            ->addColumn('actions', function (Sewer $entity) use ($actions) {
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
     * Almacenar nueva alcantarilla para una vía.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sewerRepository->createFromArray($request->all());
        if (!$entity) {
            throw new Exception(trans('sewer.messages.errors.create'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'sewer' => true
        ];
    }

    /**
     * Retornar data necesaria para mostrar la información de la alcantarilla de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function show(string $gid)
    {
        $states = State::all();
        $typeSewers = SewerType::all();
        $materialSewers = MaterialSewer::all();
        $entity = $this->sewerRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('sewer.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity,
            'states' => $states,
            'typeSewers' => $typeSewers,
            'materialSewers' => $materialSewers
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de edición de la alcantarilla de una vía.
     *
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function edit(string $gid)
    {
        $states = State::all();
        $typeSewers = SewerType::all();
        $materialSewers = MaterialSewer::all();
        $entity = $this->sewerRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('sewer.messages.exceptions.not_found'), 1000);
        }
        return [
            'entity' => $entity,
            'states' => $states,
            'typeSewers' => $typeSewers,
            'materialSewers' => $materialSewers
        ];
    }

    /**
     * Retornar data necesaria para mostrar el formulario de creación de la alcantarilla de una vía.
     *
     * @param string $code
     *
     * @return array
     */
    public function create(string $code)
    {
        $states = State::all();
        $typeSewers = SewerType::all();
        $materialSewers = MaterialSewer::all();
        return [
            'code' => $code,
            'states' => $states,
            'typeSewers' => $typeSewers,
            'materialSewers' => $materialSewers
        ];
    }

    /**
     * Actualizar la información de la alcantarilla de una vía.
     *
     * @param Request $request
     * @param string $gid
     *
     * @return array
     * @throws Exception
     */
    public function update(Request $request, string $gid)
    {
        $entity = $this->sewerRepository->findByGid($gid);
        if (!$entity) {
            throw  new Exception(trans('sewer.messages.exceptions.not_found'), 1000);
        }
        $entity = $this->sewerRepository->updateFromArray($request->all(), $entity);
        if (!$entity) {
            throw new Exception(trans('sewer.messages.errors.update'), 1000);
        }
        return [
            'entity' => $this->generalCharacteristicsOfTrackRepository->findByCode($request->codigo),
            'sewer' => true
        ];
    }
}