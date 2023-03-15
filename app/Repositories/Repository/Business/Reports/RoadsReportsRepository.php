<?php

namespace App\Repositories\Repository\Business\Reports;

use App\Models\Business\Roads\Catalogs\RollingSurfaceType;
use App\Models\Business\Roads\Catalogs\Status;
use App\Models\Business\Roads\CharacteristicsOfTrack;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Clase RoadsReportsRepository
 * @package App\Repositories\Repository\Business\Reports
 */
class RoadsReportsRepository
{

    /**
     * Obtiene la suma de la longitud de un tipo de capa de rodadura por cantón.
     *
     * @param string $canton
     * @param RollingSurfaceType $rollingSurfaceType
     *
     * @return int|mixed
     */
    public function calculateLengthBySurfaceType(string $canton, RollingSurfaceType $rollingSurfaceType)
    {
        $length = CharacteristicsOfTrack
                    ::join('caracteristicas_generales_via', 'caracteristicas_via.codigo', '=', 'caracteristicas_generales_via.codigo')
                    ->select('canton', DB::raw('SUM(longitud) as longitud'), 'tsuperf')
                    ->groupBy('canton', 'tsuperf')
                    ->having('canton', '=', $canton, 'and')
                    ->having('tsuperf', '=', $rollingSurfaceType->descrip)
                    ->get();

        if ($length->isEmpty()) {
            return 0;
        }

        return array_first($length->pluck('longitud'));
    }

    /**
     * Obtiene la suma de la longitud de un tipo de capa de rodadura según estado de la vía de un cantón.
     *
     * @param string $canton
     * @param string $status
     * @param RollingSurfaceType $rollingSurfaceType
     *
     * @return int|mixed
     */
    public function calculateLengthByStatus(string $canton, string $status, RollingSurfaceType $rollingSurfaceType)
    {
        $length = CharacteristicsOfTrack
            ::join('caracteristicas_generales_via', 'caracteristicas_via.codigo', '=', 'caracteristicas_generales_via.codigo')
            ->select('esuperf', 'canton', 'tsuperf', DB::raw('SUM(longitud) as longitud'))
            ->groupBy('canton', 'esuperf', 'tsuperf')
            ->having('canton', '=', $canton, 'and')
            ->having('esuperf', '=', $status, 'and')
            ->having('tsuperf', '=', $rollingSurfaceType->descrip)
            ->get();

        if ($length->isEmpty()) {
            return 0;
        }

        return array_first($length->pluck('longitud'));
    }

    /**
     * Obtiene la tabla de la longitud total de la red vial por cantón.
     *
     * @return Collection
     */
    public function roadTotalLength()
    {
        $query = CharacteristicsOfTrack
            ::join('caracteristicas_generales_via', 'caracteristicas_via.codigo', '=', 'caracteristicas_generales_via.codigo')
            ->select('canton', DB::raw('ROUND(SUM(longitud), 2) as length'))
            ->groupBy('canton')
            ->get();

        return $query;
    }

    /**
     * Obtiene de la BD una tabla de la longitud total de la red vial cantonal por estado de la vía.
     *
     * @param string $canton
     * @param Status $status
     *
     * @return double
     */
    public function roadTotalLengthByStatus(string $canton, Status $status)
    {
        $query = CharacteristicsOfTrack
            ::join('caracteristicas_generales_via', 'caracteristicas_via.codigo', 'caracteristicas_generales_via.codigo')
            ->select(DB::raw('SUM(longitud) as ' . $status->descripcion))
            ->groupBy('canton', 'esuperf')
            ->having('canton', '=', $canton, 'and')
            ->having('esuperf', '=', $status->descripcion)
            ->get();

        if ($query->isEmpty()) {
            return 0;
        }

        return array_first($query->pluck($status->descripcion));
    }

}
