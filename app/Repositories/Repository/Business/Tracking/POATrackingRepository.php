<?php

namespace App\Repositories\Repository\Business\Tracking;

use App\Models\Business\Planning\ActivityProjectFiscalYear;
use App\Models\Business\Planning\ProjectFiscalYear;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Illuminate\Support\Facades\DB;

/**
 * Clase POATrackingRepository
 * @package App\Repositories\Repository\Business\Tracking
 */
class POATrackingRepository
{

    const SELECT_ACCRUED_REFORMS = "trim(a.cuenta) as cuenta,
                               sum(case
                                   when (a.sig_tip NOT IN ('PR', 'RE', 'CO', 'CE'))
                                       then val_cre - val_deb
                                   else 0 end) as total_accrued,
                               sum(case
                                   when a.sig_tip = 'RE'
                                       then case when val_cre < 0 then a.val_deb + a.val_cre else a.val_deb - a.val_cre end
                                   else 0 end) as total_reform";

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var
     */
    private $apiFinancialService;

    /**
     * Constructor de POATrackingRepository.
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
     * Obtiene una colección de departamentos con sus proyectos y actividades
     *
     * @param int $fiscal_year_id
     * @param int $executingUnitId
     *
     * @return mixed
     */
    public function data(int $fiscal_year_id, int $executingUnitId)
    {
        return ActivityProjectFiscalYear::join('project_fiscal_years as pfy', 'pfy.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'pfy.project_id')
            ->join('users_manages_activities as uma', 'uma.activity_project_fiscal_year_id', '=', 'activity_project_fiscal_years.id')
            ->join('users', 'users.id', '=', 'uma.user_id')
            ->join('departments', 'departments.id', '=', 'projects.executing_unit_id')
            ->join('components', 'components.id', 'activity_project_fiscal_years.component_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->whereNull('users.deleted_at')
            ->when($executingUnitId, function ($q) use ($executingUnitId) {
                $q->where('projects.executing_unit_id', $executingUnitId);
            })
            ->where([
                'pfy.fiscal_year_id' => $fiscal_year_id,
                'pfy.status' => ProjectFiscalYear::STATUS_IN_PROGRESS,
                'uma.active' => true
            ])
            ->select(
                'activity_project_fiscal_years.*',
                'departments.name as department_name',
                'projects.name as project_name',
                'components.name as component_name',
                DB::raw("CONCAT(users.first_name,' ',users.last_name) as responsible")
            )->with(['area', 'projectFiscalYear.project.executingUnit', 'projectFiscalYear.project.subprogram.parent'])
            ->get();
    }

    /**
     * Obtiene presupuesto por actividad
     *
     * @param int $year
     * @param string $date
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function activitiesBudget(int $year)
    {
        return $this->apiFinancialService->activitiesBudgetApi($year);
    }

    /**
     * Obtiene presupuesto por actividad para avance presupuestario
     *
     * @param int $year
     * @param string $date
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function activitiesBudgetProject(int $year)
    {
        return $this->apiFinancialService->activitiesBudgetProjectApi($year);
    }
}
