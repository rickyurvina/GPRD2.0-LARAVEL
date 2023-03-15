<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\TrackUsageRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase TrackUsageProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class TrackUsageProcess
{
    /**
     * @var TrackUsageRepository
     */
    protected $trackUsageRepository;

    /**
     * Constructor de TrackUsageProcess.
     *
     * @param TrackUsageRepository $trackUsageRepository
     */
    public function __construct(
        TrackUsageRepository $trackUsageRepository
    ) {
        $this->trackUsageRepository = $trackUsageRepository;
    }

    /**
     * Cargar información de uso vía.
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $trackUsage = $this->trackUsageRepository->all();

        $dataTable = DataTables::of($trackUsage)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nuevo uso vía.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->trackUsageRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('characteristics_of_track.messages.errors.create_track_usage'), 1000);
        }

        return $entity;
    }
}