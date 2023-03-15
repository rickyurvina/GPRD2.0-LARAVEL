<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\PopulationTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase PopulationTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class PopulationTypeProcess
{
    /**
     * @var PopulationTypeRepository
     */
    protected $populationTypeRepository;

    /**
     * Constructor de PopulationTypeProcess.
     *
     * @param PopulationTypeRepository $populationTypeRepository
     */
    public function __construct(
        PopulationTypeRepository $populationTypeRepository
    ) {
        $this->populationTypeRepository = $populationTypeRepository;
    }

    /**
     * Cargar información del tipo de población.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $populationType = $this->populationTypeRepository->all();

        $dataTable = DataTables::of($populationType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de población.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->populationTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('ditch.messages.errors.create_population_type'), 1000);
        }

        return $entity;
    }
}