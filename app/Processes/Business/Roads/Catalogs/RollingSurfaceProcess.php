<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\RollingSurfaceRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase RollingSurfaceProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class RollingSurfaceProcess
{
    /**
     * @var RollingSurfaceRepository
     */
    protected $rollingSurfaceRepository;

    /**
     * Constructor de RollingSurfaceProcess.
     *
     * @param RollingSurfaceRepository $rollingSurfaceRepository
     */
    public function __construct(
        RollingSurfaceRepository $rollingSurfaceRepository
    ) {
        $this->rollingSurfaceRepository = $rollingSurfaceRepository;
    }

    /**
     * Cargar información de la superficie de rodadura.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $rollingSurface = $this->rollingSurfaceRepository->all();

        $dataTable = DataTables::of($rollingSurface)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nueva superficie de rodadura.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->rollingSurfaceRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_rolling_surface'), 1000);
        }

        return $entity;
    }
}