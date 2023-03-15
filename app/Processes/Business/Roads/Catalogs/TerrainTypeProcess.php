<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\TerrainTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase TerrainTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class TerrainTypeProcess
{
    /**
     * @var TerrainTypeRepository
     */
    protected $terrainTypeRepository;

    /**
     * Constructor de TerrainTypeProcess.
     *
     * @param TerrainTypeRepository $terrainTypeRepository
     */
    public function __construct(
        TerrainTypeRepository $terrainTypeRepository
    ) {
        $this->terrainTypeRepository = $terrainTypeRepository;
    }

    /**
     * Cargar información del carril.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $terrainType = $this->terrainTypeRepository->all();

        $dataTable = DataTables::of($terrainType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo carril.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->terrainTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('characteristics_of_track.messages.errors.create_terrain_type'), 1000);
        }

        return $entity;
    }
}