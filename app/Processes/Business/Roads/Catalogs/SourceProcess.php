<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\SourceRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase SourceProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class SourceProcess
{
    /**
     * @var SourceRepository
     */
    protected $sourceRepository;

    /**
     * Constructor de SourceProcess.
     *
     * @param SourceRepository $sourceRepository
     */
    public function __construct(
        SourceRepository $sourceRepository
    ) {
        $this->sourceRepository = $sourceRepository;
    }

    /**
     * Cargar información de la fuente.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $source = $this->sourceRepository->all();

        $dataTable = DataTables::of($source)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nueva fuente.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->sourceRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('mines.messages.errors.create_source'), 1000);
        }

        return $entity;
    }
}