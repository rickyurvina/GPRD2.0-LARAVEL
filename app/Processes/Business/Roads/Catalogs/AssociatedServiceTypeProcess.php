<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\AssociatedServiceTypeRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase AssociatedServiceTypeProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class AssociatedServiceTypeProcess
{
    /**
     * @var AssociatedServiceTypeRepository
     */
    protected $associatedServiceTypeRepository;

    /**
     * Constructor de AssociatedServiceTypeProcess.
     *
     * @param AssociatedServiceTypeRepository $associatedServiceTypeRepository
     */
    public function __construct(
        AssociatedServiceTypeRepository $associatedServiceTypeRepository
    ) {
        $this->associatedServiceTypeRepository = $associatedServiceTypeRepository;
    }

    /**
     * Cargar información del tipo de servicio asociado.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $associatedServiceType = $this->associatedServiceTypeRepository->all();

        $dataTable = DataTables::of($associatedServiceType)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo tipo de servicio asociado.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->associatedServiceTypeRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('transportation_services.messages.errors.create_associated_service_type'), 1000);
        }

        return $entity;
    }
}