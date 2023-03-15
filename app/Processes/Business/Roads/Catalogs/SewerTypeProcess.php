<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SewerTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SewerTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SewerTypeProcess
{
    /**
     * @var SewerTypeRepository
     */
    protected $sewerTypeRepository;

    /**
     * Constructor de SewerTypeProcess.
     *
     * @param SewerTypeRepository $sewerTypeRepository
     */
    public function __construct(
        SewerTypeRepository $sewerTypeRepository
    ) {
        $this->sewerTypeRepository = $sewerTypeRepository;
    }

    /**
     * Cargar información del tipo de alcantarilla.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $sewerType = $this->sewerTypeRepository->all();

        $dataTable = DataTables::of($sewerType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de alcantarilla.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sewerTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('sewer.messages.errors.create_type'), 1000);
        }

        return $entity;
    }
}