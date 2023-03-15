<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\ProductiveSectorRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase ProductiveSectorProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class ProductiveSectorProcess
{
    /**
     * @var ProductiveSectorRepository
     */
    protected $productiveSectorRepository;

    /**
     * Constructor de ProductiveSectorProcess.
     *
     * @param ProductiveSectorRepository $productiveSectorRepository
     */
    public function __construct(
        ProductiveSectorRepository $productiveSectorRepository
    ) {
        $this->productiveSectorRepository = $productiveSectorRepository;
    }

    /**
     * Cargar información del sector productivo.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $productiveSector = $this->productiveSectorRepository->all();

        $dataTable = DataTables::of($productiveSector)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo sector productivo.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->productiveSectorRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('production.messages.errors.create_productive_sector'), 1000);
        }

        return $entity;
    }
}