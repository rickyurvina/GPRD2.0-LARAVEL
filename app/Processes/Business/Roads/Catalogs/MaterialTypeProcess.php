<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\MaterialTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase MaterialTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class MaterialTypeProcess
{
    /**
     * @var MaterialTypeRepository
     */
    protected $materialTypeRepository;

    /**
     * Constructor de MaterialTypeProcess.
     *
     * @param MaterialTypeRepository $materialTypeRepository
     */
    public function __construct(
        MaterialTypeRepository $materialTypeRepository
    ) {
        $this->materialTypeRepository = $materialTypeRepository;
    }

    /**
     * Cargar información del tipo de material.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $materialType = $this->materialTypeRepository->all();

        $dataTable = DataTables::of($materialType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de material.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->materialTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('hdm4.messages.errors.create_material_type'), 1000);
        }

        return $entity;
    }
}