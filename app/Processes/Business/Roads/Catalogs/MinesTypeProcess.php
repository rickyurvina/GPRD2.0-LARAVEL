<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\MinesTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase MinesTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class MinesTypeProcess
{
    /**
     * @var MinesTypeRepository
     */
    protected $minesTypeRepository;

    /**
     * Constructor de MinesTypeProcess.
     *
     * @param MinesTypeRepository $minesTypeRepository
     */
    public function __construct(
        MinesTypeRepository $minesTypeRepository
    ) {
        $this->minesTypeRepository = $minesTypeRepository;
    }

    /**
     * Cargar información del tipo de minas.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $minesType = $this->minesTypeRepository->all();

        $dataTable = DataTables::of($minesType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de minas.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->minesTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('mines.messages.errors.create_mines_type'), 1000);
        }

        return $entity;
    }
}