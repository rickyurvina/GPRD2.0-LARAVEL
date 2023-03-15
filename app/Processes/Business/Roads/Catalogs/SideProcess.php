<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SideRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SideProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SideProcess
{
    /**
     * @var SideRepository
     */
    protected $sideRepository;

    /**
     * Constructor de SideProcess.
     *
     * @param SideRepository $sideRepository
     */
    public function __construct(
        SideRepository $sideRepository
    ) {
        $this->sideRepository = $sideRepository;
    }

    /**
     * Cargar información del lado.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $side = $this->sideRepository->all();

        $dataTable = DataTables::of($side)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo lado.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sideRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('ditch.messages.errors.create_side'), 1000);
        }

        return $entity;
    }
}