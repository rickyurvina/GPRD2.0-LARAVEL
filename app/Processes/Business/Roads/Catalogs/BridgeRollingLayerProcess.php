<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\BridgeRollingLayerRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase BridgeRollingLayerProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class BridgeRollingLayerProcess
{
    /**
     * @var BridgeRollingLayerRepository
     */
    protected $bridgeRollingLayerRepository;

    /**
     * Constructor de BridgeRollingLayerProcess.
     *
     * @param BridgeRollingLayerRepository $bridgeRollingLayerRepository
     */
    public function __construct(
        BridgeRollingLayerRepository $bridgeRollingLayerRepository
    ) {
        $this->bridgeRollingLayerRepository = $bridgeRollingLayerRepository;
    }

    /**
     * Cargar información de la capa rodadura puente.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $bridgeRollingLayers = $this->bridgeRollingLayerRepository->all();

        $dataTable = DataTables::of($bridgeRollingLayers)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nueva capa rodadura puente.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->bridgeRollingLayerRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('sewer.messages.errors.create'), 1000);
        }

        return $entity;
    }
}