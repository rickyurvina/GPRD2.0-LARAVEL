<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\VerticalSignalTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase VerticalSignalTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class VerticalSignalTypeProcess
{
    /**
     * @var VerticalSignalTypeRepository
     */
    protected $verticalSignalTypeRepository;

    /**
     * Constructor de VerticalSignalTypeProcess.
     *
     * @param VerticalSignalTypeRepository $verticalSignalTypeRepository
     */
    public function __construct(
        VerticalSignalTypeRepository $verticalSignalTypeRepository
    ) {
        $this->verticalSignalTypeRepository = $verticalSignalTypeRepository;
    }

    /**
     * Cargar información del tipo de señal vertical.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $verticalSignalType = $this->verticalSignalTypeRepository->all();

        $dataTable = DataTables::of($verticalSignalType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de señal vertical.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->verticalSignalTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('signal_vertical.messages.errors.create_vertical_signal_type'), 1000);
        }

        return $entity;
    }
}