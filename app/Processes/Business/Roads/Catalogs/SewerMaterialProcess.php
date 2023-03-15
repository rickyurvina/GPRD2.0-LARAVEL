<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SewerMaterialRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SewerMaterialProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SewerMaterialProcess
{
    /**
     * @var SewerMaterialRepository
     */
    protected $sewerMaterialRepository;

    /**
     * Constructor de SewerMaterialProcess.
     *
     * @param SewerMaterialRepository $sewerMaterialRepository
     */
    public function __construct(
        SewerMaterialRepository $sewerMaterialRepository
    ) {
        $this->sewerMaterialRepository = $sewerMaterialRepository;
    }

    /**
     * Cargar información del material de alcantarilla.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $sewerMaterial = $this->sewerMaterialRepository->all();

        $dataTable = DataTables::of($sewerMaterial)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo material de alcantarilla.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sewerMaterialRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('sewer.messages.errors.create_sewer_material'), 1000);
        }

        return $entity;
    }
}