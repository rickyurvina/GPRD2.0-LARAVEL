<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\StatusRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase StatusProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class StatusProcess
{
    /**
     * @var StatusRepository
     */
    protected $statusRepository;

    /**
     * Constructor de StatusProcess.
     *
     * @param StatusRepository $statusRepository
     */
    public function __construct(
        StatusRepository $statusRepository
    ) {
        $this->statusRepository = $statusRepository;
    }

    /**
     * Cargar información de los estados.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $status = $this->statusRepository->listActive();

        $dataTable = DataTables::of($status)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo estado.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->statusRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('general_characteristics_of_track.messages.errors.create_status'), 1000);
        }

        return $entity;
    }
}