<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\RollingSurfaceTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase RollingSurfaceTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class RollingSurfaceTypeProcess
{
    /**
     * @var RollingSurfaceTypeRepository
     */
    protected $rollingSurfaceTypeRepository;

    /**
     * Constructor de RollingSurfaceTypeProcess.
     *
     * @param RollingSurfaceTypeRepository $rollingSurfaceTypeRepository
     */
    public function __construct(
        RollingSurfaceTypeRepository $rollingSurfaceTypeRepository
    ) {
        $this->rollingSurfaceTypeRepository = $rollingSurfaceTypeRepository;
    }

    /**
     * Cargar información del tipo de superficie de rodadura.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $rollingSurfaceType = $this->rollingSurfaceTypeRepository->listActive();

        $dataTable = DataTables::of($rollingSurfaceType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }
}