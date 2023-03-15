<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\TypeConservationNeedRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase TypeConservationNeedProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class TypeConservationNeedProcess
{
    /**
     * @var TypeConservationNeedRepository
     */
    protected $typeConservationNeedRepository;

    /**
     * Constructor de TypeConservationNeedProcess.
     *
     * @param TypeConservationNeedRepository $typeConservationNeedRepository
     */
    public function __construct(
        TypeConservationNeedRepository $typeConservationNeedRepository
    ) {
        $this->typeConservationNeedRepository = $typeConservationNeedRepository;
    }

    /**
     * Cargar información del tipo de necesidad de conservación.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $typeConservationNeed = $this->typeConservationNeedRepository->all();

        $dataTable = DataTables::of($typeConservationNeed)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de necesidad de conservación.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->typeConservationNeedRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('conservation_needs.messages.errors.create_type_conservation_need'), 1000);
        }

        return $entity;
    }
}