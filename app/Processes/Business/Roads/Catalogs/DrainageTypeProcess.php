<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\DrainageTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase DrainageTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class DrainageTypeProcess
{
    /**
     * @var DrainageTypeRepository
     */
    protected $drainageTypeRepository;

    /**
     * Constructor de DrainageTypeProcess.
     *
     * @param DrainageTypeRepository $drainageTypeRepository
     */
    public function __construct(
        DrainageTypeRepository $drainageTypeRepository
    ) {
        $this->drainageTypeRepository = $drainageTypeRepository;
    }

    /**
     * Cargar información del tipo de drenaje.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $drainageType = $this->drainageTypeRepository->all();

        $dataTable = DataTables::of($drainageType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de drenaje.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->drainageTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_drainage_type'), 1000);
        }

        return $entity;
    }
}