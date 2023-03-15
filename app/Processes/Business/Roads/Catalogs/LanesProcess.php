<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\LanesRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase LanesProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class LanesProcess
{
    /**
     * @var LanesRepository
     */
    protected $lanesRepository;

    /**
     * Constructor de LanesProcess.
     *
     * @param LanesRepository $lanesRepository
     */
    public function __construct(
        LanesRepository $lanesRepository
    ) {
        $this->lanesRepository = $lanesRepository;
    }

    /**
     * Cargar información del carril.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $lanes = $this->lanesRepository->all();

        $dataTable = DataTables::of($lanes)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }
}