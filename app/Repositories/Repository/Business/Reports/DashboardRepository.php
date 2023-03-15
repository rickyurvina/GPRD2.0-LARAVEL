<?php

namespace App\Repositories\Repository\Business\Reports;

use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Illuminate\Http\Client\Response;

/**
 * Clase DashboardRepository
 *
 * @package App\Repositories\Repository\Business\Reports
 */
class DashboardRepository
{

    /**
     * @var SettingRepository
     */
    private $settingRepository;
    /**
     * @var
     */
    private $apiFinancialService;

    /**
     * Constructor de DashboardRepository.
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository   $settingRepository,
                                ApiFinancialService $apiFinancialService)
    {
        $this->settingRepository = $settingRepository;
        $this->apiFinancialService = $apiFinancialService;
    }

    /**
     * Obtiene los detalles del presupuesto de ingresos
     *
     * @param int $year
     * @param string $date
     * @param int $type
     *
     * @return Response
     * @throws \Exception
     */
    public function totalsBudgetByType(int $year, string $date, int $type = 1)
    {
        return $this->apiFinancialService->totalsBudgetByTypeApi($year, $type);
    }

    /**
     * Obtiene presupuesto por fuente de financiamiento
     *
     * @param int $year
     * @param string $date
     * @param int $from
     * @param int $length
     * @param int $level
     * @param int $type
     *
     * @return Response
     * @throws \Exception
     */
    public function budgetByCategory(int $year, string $date, int $from, int $length, int $level, int $type = 1)
    {
        return $this->apiFinancialService->budgetByCategoryApi($year, $from, $length, $level, $type);
    }

    /**
     * Obtiene la ejecución del presupuesto por mes
     *
     * @param int $year
     *
     * @return Response
     * @throws \Exception
     */
    public function budgetMonthlyExecution(int $year)
    {
        return $this->apiFinancialService->budgetMonthlyExecutionApi($year);
    }

    /**
     * Obtiene los detalles de los proyectos
     *
     * @param int $year
     * @param string $date
     * @param int $type
     *
     * @return Response
     * @throws \Exception
     */
    public function totalsProjectByType(int $year, string $date, int $type = 1)
    {
        return $this->apiFinancialService->totalsProjectByTypeApi($year, $type);
    }


    /**
     * Obtiene la ejecución del presupuesto por mes de proyectos
     *
     * @param int $year
     *
     * @return Response
     * @throws \Exception
     */
    public function projectMonthlyExecution(int $year)
    {
        return $this->apiFinancialService->projectMonthlyExecutionApi($year);
    }

    /**
     * Obtiene presupuesto por fuente de financiamiento
     *
     * @param int $year
     * @param string $date
     * @param int $from
     * @param int $length
     * @param int $level
     * @param int $type
     *
     * @return Response
     * @throws \Exception
     */
    public function projectByCategory(int $year, string $date, int $from, int $length, int $level, int $type = 1)
    {
        return $this->apiFinancialService->projectByCategoryApi($year, $from, $length, $level, $type);
    }

}
