<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\MinesMaterialRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase MinesMaterialProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class MinesMaterialProcess
{
    /**
     * @var MinesMaterialRepository
     */
    protected $minesMaterialRepository;

    /**
     * Constructor de MinesMaterialProcess.
     *
     * @param MinesMaterialRepository $minesMaterialRepository
     */
    public function __construct(
        MinesMaterialRepository $minesMaterialRepository
    ) {
        $this->minesMaterialRepository = $minesMaterialRepository;
    }

    /**
     * Cargar información del material de minas.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $minesMaterial = $this->minesMaterialRepository->all();

        $dataTable = DataTables::of($minesMaterial)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo material de minas.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->minesMaterialRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('mines.messages.errors.create_mines_material'), 1000);
        }

        return $entity;
    }
}