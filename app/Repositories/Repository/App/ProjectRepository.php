<?php

namespace App\Repositories\Repository\App;

use App\Models\Business\Planning\ProjectFiscalYear;
use App\Models\Business\Project;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;

/**
 * Clase ProjectRepository
 *
 * @package App\Repositories\Repository\App
 */
class ProjectRepository
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
    public function __construct(SettingRepository   $settingRepository,
                                ApiFinancialService $apiFinancialService)
    {
        $this->settingRepository = $settingRepository;
        $this->apiFinancialService = $apiFinancialService;
    }

    /**
     *
     * Proyectos por Unidad Ejecutora
     *
     * @param int $fiscalYearId
     * @param int $executingUnitId
     *
     * @return mixed
     */
    public function findByExecutingUnit(int $fiscalYearId, int $executingUnitId)
    {
        return Project::join('project_fiscal_years', 'project_fiscal_years.project_id', 'projects.id')
            ->join('departments', 'projects.executing_unit_id', 'departments.id')
            ->whereNull('projects.deleted_at')
            ->where([
                ['project_fiscal_years.fiscal_year_id', '=', $fiscalYearId],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['projects.status', '=', Project::STATUS_IN_PROGRESS],
                ['projects.executing_unit_id', '=', $executingUnitId]
            ])->select('projects.*')->get();
    }

    public function findByLocation(int $fiscalYearId, int $locationId)
    {
        return Project::join('project_fiscal_years', 'project_fiscal_years.project_id', 'projects.id')
            ->join('activity_project_fiscal_years', 'activity_project_fiscal_years.project_fiscal_year_id', 'project_fiscal_years.id')
            ->join('budget_items', 'budget_items.activity_project_fiscal_year_id', 'activity_project_fiscal_years.id')
            ->join('budget_item_locations', 'budget_item_locations.budget_item_id', 'budget_items.id')
            ->whereNull('projects.deleted_at')
            ->where([
                ['project_fiscal_years.fiscal_year_id', '=', $fiscalYearId],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['projects.status', '=', Project::STATUS_IN_PROGRESS],
                ['budget_item_locations.location_id', '=', $locationId],
            ])->select('projects.*')->distinct()->get();
    }

    /**
     *  Presupuesto de proyectos
     *
     * @param int $year
     * @param string $date
     * @param array $projectCodes
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getProjectBudget(int $year, string $date, array $projectCodes = []): \Illuminate\Http\Client\Response
    {
        return $this->apiFinancialService->getProjectBudgetApi($year,$projectCodes);
    }
}
