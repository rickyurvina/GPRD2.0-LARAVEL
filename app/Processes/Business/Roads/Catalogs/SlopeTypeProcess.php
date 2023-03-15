<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SlopeTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SlopeTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SlopeTypeProcess
{
    /**
     * @var SlopeTypeRepository
     */
    protected $slopeTypeRepository;

    /**
     * Constructor de SlopeTypeProcess.
     *
     * @param SlopeTypeRepository $slopeTypeRepository
     */
    public function __construct(
        SlopeTypeRepository $slopeTypeRepository
    ) {
        $this->slopeTypeRepository = $slopeTypeRepository;
    }

    /**
     * Cargar información del tipo de talud.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $slopeType = $this->slopeTypeRepository->all();

        $dataTable = DataTables::of($slopeType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de talud.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->slopeTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('slope.messages.errors.create_slope_type'), 1000);
        }

        return $entity;
    }
}