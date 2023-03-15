<?php

namespace App\Repositories\Repository\App;

use App\Models\Business\Planning\ActivityProjectFiscalYear;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;

/**
 * Clase ActivityRepository
 *
 * @package App\Repositories\Repository\App
 */
class ActivityRepository
{
    /**
     * @var mixed
     */
    private $sfgprov;

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var
     */
    private $apiFinancialService;

    /**
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository, ApiFinancialService $apiFinancialService)
    {
        $this->settingRepository = $settingRepository;
        $this->apiFinancialService = $apiFinancialService;
    }

    public function findByProject(int $projectFiscalYearId)
    {
        return ActivityProjectFiscalYear::join('project_fiscal_years', 'project_fiscal_years.id', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->where([
                ['project_fiscal_years.id', '=', $projectFiscalYearId]
            ])->with(['tasks', 'area', 'projectFiscalYear.project.executingUnit', 'projectFiscalYear.project.subprogram.parent', 'responsible'])
            ->select('activity_project_fiscal_years.*')->get();
    }

    /**
     *  Presupuesto de proyectos
     *
     * @param int $year
     * @param string $date
     * @param array $activitiesCodes
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getActivitiesBudget(int $year, string $date, array $activitiesCodes = [])
    {
        return $this->apiFinancialService->getActivitiesBudgetApi($year, $activitiesCodes);
    }

}
