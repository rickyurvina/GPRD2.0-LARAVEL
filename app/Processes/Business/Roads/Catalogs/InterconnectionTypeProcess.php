<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\InterconnectionTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase InterconnectionTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class InterconnectionTypeProcess
{
    /**
     * @var InterconnectionTypeRepository
     */
    protected $interconnectionTypeRepository;

    /**
     * Constructor de InterconnectionTypeProcess.
     *
     * @param InterconnectionTypeRepository $interconnectionTypeRepository
     */
    public function __construct(
        InterconnectionTypeRepository $interconnectionTypeRepository
    ) {
        $this->interconnectionTypeRepository = $interconnectionTypeRepository;
    }

    /**
     * Cargar información del tipo de interconexión.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $interconnectionType = $this->interconnectionTypeRepository->all();

        $dataTable = DataTables::of($interconnectionType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de interconexión.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->interconnectionTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('general_characteristics_of_track.messages.errors.create_interconnection_type'), 1000);
        }

        return $entity;
    }
}