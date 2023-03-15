<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\DrainageStatusRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase DrainageStatusProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class DrainageStatusProcess
{
    /**
     * @var DrainageStatusRepository
     */
    protected $drainageStatusRepository;

    /**
     * Constructor de DrainageStatusProcess.
     *
     * @param DrainageStatusRepository $drainageStatusRepository
     */
    public function __construct(
        DrainageStatusRepository $drainageStatusRepository
    ) {
        $this->drainageStatusRepository = $drainageStatusRepository;
    }

    /**
     * Cargar información del estado de drenaje.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $drainageStatus = $this->drainageStatusRepository->all();

        $dataTable = DataTables::of($drainageStatus)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo estado de drenaje.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->drainageStatusRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_drainage_status'), 1000);
        }

        return $entity;
    }
}