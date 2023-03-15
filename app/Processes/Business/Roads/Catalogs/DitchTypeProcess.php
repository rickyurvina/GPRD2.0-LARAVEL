<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\DitchTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase DitchTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class DitchTypeProcess
{
    /**
     * @var DitchTypeRepository
     */
    protected $ditchTypeRepository;

    /**
     * Constructor de DitchTypeProcess.
     *
     * @param DitchTypeRepository $ditchTypeRepository
     */
    public function __construct(
        DitchTypeRepository $ditchTypeRepository
    ) {
        $this->ditchTypeRepository = $ditchTypeRepository;
    }

    /**
     * Cargar información del tipo de cuneta.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $ditchType = $this->ditchTypeRepository->all();

        $dataTable = DataTables::of($ditchType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de cuneta.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->ditchTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('ditch.messages.errors.create_ditch_type'), 1000);
        }

        return $entity;
    }
}