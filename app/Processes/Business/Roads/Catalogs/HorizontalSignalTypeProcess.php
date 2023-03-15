<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\HorizontalSignalTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase HorizontalSignalTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class HorizontalSignalTypeProcess
{
    /**
     * @var HorizontalSignalTypeRepository
     */
    protected $horizontalSignalTypeRepository;

    /**
     * Constructor de HorizontalSignalTypeProcess.
     *
     * @param HorizontalSignalTypeRepository $horizontalSignalTypeRepository
     */
    public function __construct(
        HorizontalSignalTypeRepository $horizontalSignalTypeRepository
    ) {
        $this->horizontalSignalTypeRepository = $horizontalSignalTypeRepository;
    }

    /**
     * Cargar información del tipo de señal horizontal.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $horizontalSignalType = $this->horizontalSignalTypeRepository->all();

        $dataTable = DataTables::of($horizontalSignalType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de señal horizontal.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->horizontalSignalTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('signal_horizontal.messages.errors.create_horizontal_signal_type'), 1000);
        }

        return $entity;
    }
}