<?php

namespace App\Processes\Business\Roads\Catalogs;

use App\Repositories\Repository\Business\Roads\Catalogs\WeatherConditionsRepository;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Exception;

/**
 * Clase WeatherConditionsProcess
 * @package App\Processes\Business\Roads\Catalogs
 */
class WeatherConditionsProcess
{
    /**
     * @var WeatherConditionsRepository
     */
    protected $weatherConditionsRepository;

    /**
     * Constructor de WeatherConditionsProcess.
     *
     * @param WeatherConditionsRepository $weatherConditionsRepository
     */
    public function __construct(
        WeatherConditionsRepository $weatherConditionsRepository
    ) {
        $this->weatherConditionsRepository = $weatherConditionsRepository;
    }

    /**
     * Cargar información de las condiciones climáticas
     *
     * @return mixed
     * @throws Exception
     */
    public function data()
    {
        $weatherConditions = $this->weatherConditionsRepository->all();

        $dataTable = DataTables::of($weatherConditions)
            ->setRowId('descrip')
            ->make(true);

        return $dataTable;
    }

    /**
     * Almacenar nueva condición climática.
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function store(Request $request)
    {
        $entity = $this->weatherConditionsRepository->createFromArray($request->all());

        if (!$entity) {
            throw new Exception(trans('general_characteristics_of_track.messages.errors.create_weather_condition'), 1000);
        }

        return $entity;
    }
}