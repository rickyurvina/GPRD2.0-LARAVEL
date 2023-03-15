<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\DayTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase DayTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class DayTypeProcess
{
    /**
     * @var DayTypeRepository
     */
    protected $dayTypeRepository;

    /**
     * Constructor de DayTypeProcess.
     *
     * @param DayTypeRepository $dayTypeRepository
     */
    public function __construct(
        DayTypeRepository $dayTypeRepository
    ) {
        $this->dayTypeRepository = $dayTypeRepository;
    }

    /**
     * Cargar información del tipo de día.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $dayType = $this->dayTypeRepository->all();

        $dataTable = DataTables::of($dayType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de día.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->dayTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('traffic.messages.errors.create_day_type'), 1000);
        }

        return $entity;
    }
}