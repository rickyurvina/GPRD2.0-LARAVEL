<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\CriticalPointTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase CriticalPointTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class CriticalPointTypeProcess
{
    /**
     * @var CriticalPointTypeRepository
     */
    protected $criticalPointTypeRepository;

    /**
     * Constructor de CriticalPointTypeProcess.
     *
     * @param CriticalPointTypeRepository $criticalPointTypeRepository
     */
    public function __construct(
        CriticalPointTypeRepository $criticalPointTypeRepository
    ) {
        $this->criticalPointTypeRepository = $criticalPointTypeRepository;
    }

    /**
     * Cargar información del tipo de punto crítico.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $criticalPointType = $this->criticalPointTypeRepository->all();

        $dataTable = DataTables::of($criticalPointType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de punto crítico.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->criticalPointTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('critical_point.messages.errors.create_critical_point_type'), 1000);
        }

        return $entity;
    }
}