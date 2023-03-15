<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\ClimaticFloorRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase ClimaticFloorProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class ClimaticFloorProcess
{
    /**
     * @var ClimaticFloorRepository
     */
    protected $climaticFloorRepository;

    /**
     * Constructor de ClimaticFloorProcess.
     *
     * @param ClimaticFloorRepository $climaticFloorRepository
     */
    public function __construct(
        ClimaticFloorRepository $climaticFloorRepository
    ) {
        $this->climaticFloorRepository = $climaticFloorRepository;
    }

    /**
     * Cargar información del piso climático.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $climaticFloor = $this->climaticFloorRepository->all();

        $dataTable = DataTables::of($climaticFloor)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo piso climático.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->climaticFloorRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_climatic_floor'), 1000);
        }

        return $entity;
    }
}