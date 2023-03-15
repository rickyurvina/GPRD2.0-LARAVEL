<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SideProtectionsRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SideProtectionsProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SideProtectionsProcess
{
    /**
     * @var SideProtectionsRepository
     */
    protected $sideProtectionsRepository;

    /**
     * Constructor de SideProtectionsProcess.
     *
     * @param SideProtectionsRepository $sideProtectionsRepository
     */

    public function __construct(
        SideProtectionsRepository $sideProtectionsRepository
    ) {
        $this->sideProtectionsRepository = $sideProtectionsRepository;
    }

    /**
     * Cargar información del protecciones laterales.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $sideProtections = $this->sideProtectionsRepository->all();

        $dataTable = DataTables::of($sideProtections)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nueva protección lateral.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sideProtectionsRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('bridge.messages.errors.create_side_protection'), 1000);
        }

        return $entity;
    }
}