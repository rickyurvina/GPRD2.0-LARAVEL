<?php

namespace App\Processes\App;

use App\Repositories\Repository\App\DepartmentRepository;
use App\Repositories\Repository\Business\Catalogs\ActivityTypeRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\Facades\DataTables;

/**
 * Clase DepartmentProcess
 *
 * @package App\Processes\App
 */
class DepartmentProcess
{
    /**
     * @var DepartmentRepository
     */
    private $departmentRepository;

    /**
     * Constructor de ActivityTypeProcess.
     *
     * @param DepartmentRepository $departmentRepository
     */
    public function __construct(DepartmentRepository $departmentRepository)
    {
        $this->departmentRepository = $departmentRepository;
    }

    public function getDepartmentsTotals(int $year): Collection
    {
        return $this->departmentRepository->totalsByYear($year);
    }

}
