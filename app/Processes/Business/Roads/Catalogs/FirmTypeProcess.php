<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\FirmTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase FirmTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class FirmTypeProcess
{
    /**
     * @var FirmTypeRepository
     */
    protected $firmTypeRepository;

    /**
     * Constructor de FirmTypeProcess.
     *
     * @param FirmTypeRepository $firmTypeRepository
     */
    public function __construct(
        FirmTypeRepository $firmTypeRepository
    ) {
        $this->firmTypeRepository = $firmTypeRepository;
    }

    /**
     * Cargar información del tipo firme.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $firmType = $this->firmTypeRepository->all();

        $dataTable = DataTables::of($firmType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo firme.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->firmTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_firm_type'), 1000);
        }

        return $entity;
    }
}