<?php

namespace App\Repositories\Repository\Business\Reports;

use App\Models\Business\BudgetItem;
use App\Models\Business\Plan;
use App\Models\Business\Planning\FiscalYear;
use App\Models\Business\Planning\ProjectFiscalYear;
use App\Models\Business\PublicPurchase;
use App\Models\Business\Task;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\DB;

/**
 * Clase TrackingReportsRepository
 *
 * @package App\Repositories\Repository\Business\Reports
 */
class TrackingReportsRepository
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
     * Constructor de TrackingReportsRepository.
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(SettingRepository $settingRepository, ApiFinancialService $apiFinancialService)
    {
        $this->settingRepository = $settingRepository;
        $this->apiFinancialService = $apiFinancialService;
    }

    /**
     * Obtener infomación del reporte poa
     *
     * @param FiscalYear $fiscalYear
     * @param array $filters
     *
     * @return BudgetItem[]|Builder[]|Collection
     * @throws Exception
     */
    public function poaReport(FiscalYear $fiscalYear, array $filters)
    {
        $budgetItemsFromOperationalActivities = BudgetItem::join('operational_activities', 'operational_activities.id', '=', 'budget_items.operational_activity_id')
            ->join('current_expenditure_elements', 'operational_activities.current_expenditure_element_id', 'current_expenditure_elements.id')
            ->where('budget_items.fiscal_year_id', $fiscalYear->id)
            ->when($filters['executing_unit'] != '0', function ($query) use ($filters) {
                return $query->where('operational_activities.executing_unit_id', $filters['executing_unit']);
            })
            ->when($filters['project'] != '0', function ($query) {
                return $query->where('budget_items.id', -1);
            })
            ->select('budget_items.*')
            ->with([
                'budgetClassifier',
                'geographicLocation',
                'source',
                'spendingGuide',
                'competence',
                'institution',
                'operationalActivity.subprogram.parent.area',
                'operationalActivity.executingUnit'
            ]);

        $budgetItems = BudgetItem::join('activity_project_fiscal_years', 'activity_project_fiscal_years.id', '=', 'budget_items.activity_project_fiscal_year_id')
            ->join('project_fiscal_years', 'project_fiscal_years.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->where([
                ['budget_items.fiscal_year_id', '=', $fiscalYear->id],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED]
            ])
            ->when($filters['executing_unit'] != '0', function ($query) use ($filters) {
                return $query->where('projects.executing_unit_id', $filters['executing_unit']);
            })
            ->when($filters['project'] != '0', function ($query) use ($filters) {
                return $query->where('projects.id', $filters['project']);
            })
            ->with([
                'budgetClassifier',
                'geographicLocation',
                'source',
                'spendingGuide',
                'competence',
                'institution',
                'activityProjectFiscalYear.area',
                'activityProjectFiscalYear.projectFiscalYear',
                'activityProjectFiscalYear.component.project.executingUnit',
                'activityProjectFiscalYear.component.project.subprogram.parent'
            ])
            ->select('budget_items.*')
            ->union($budgetItemsFromOperationalActivities)
            ->get();
        $sfgprov = json_decode($this->settingRepository->findByKey('gad'))->value->sfgprov;
        if ($sfgprov->exist) {
            return self::remotePOAQuery($budgetItems, $fiscalYear);
        } else {
            throw new Exception(trans('reports.exceptions.finance_system_not_found'), 1000);
        }
    }

    /**
     * Consulta información de las partidas presupuestarias en la base de datos del sistema financiero
     *
     * @param Collection $budgetItems
     * @param FiscalYear $fiscalYear
     *
     * @return Collection
     * @throws Exception
     */
    private function remotePOAQuery(Collection $budgetItems, FiscalYear $fiscalYear)
    {
        $financeBudgetItems = api_available() ? $this->apiFinancialService->remotePOAQueryApi($fiscalYear->year) : collect([]);
        $result = $budgetItems->map(function ($item) use ($financeBudgetItems) {

            $bi = $financeBudgetItems->firstWhere('cuenta', $item->code);
            if (!$bi) {
                return $item;
            }
            foreach ($bi as $key => $value) {
                $item->setAttribute($key, $value);
            }
            return $item;
        });

        return $result;
    }


    /**
     * Obtiene información presupuestaria de las partidas
     *
     * @param int $year
     * @param string $date
     * @param int $itemType
     * @param int $level
     * @param string $operator
     * @param int $allItems
     * @param string $item
     * @param string $executingUnit
     *
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetCard(int $year, string $date, int $itemType, int $level, string $operator, int $allItems = 0, string $item = '', string $executingUnit = '')
    {
        return $this->apiFinancialService->budgetCardApi($year, $itemType, $level, $operator, $allItems, $itemType, $executingUnit);
    }

    /**
     * @param int $year
     * @param int $itemType
     * @param int $level
     * @param int $allItems
     * @param string $item
     * @param string $executingUnit
     * @return Response
     * @throws Exception
     */
    public function budgetCard2(int $year, int $itemType = 1, int $level = 1, int $allItems = 0, string $item = '', string $executingUnit = ''): Response
    {
        return $this->apiFinancialService->budgetCard2Api($year, $itemType, $level, $allItems, $item);
    }

    /**
     * Obtiene los niveles de la estructura de Ingreso o Gasto
     *
     * @param int $year
     * @param int $type
     *
     * @return Response
     * @throws Exception
     */
    public function structureLevels(int $year, int $type = 1): Response // 1 => Tipo Gasto
    {
        return $this->apiFinancialService->structureLevelsApi($year, $type);
    }

    /**
     * Buscar en la BD los proyectos en ejecución.
     *
     * @param FiscalYear $fiscalYear
     * @param int $executingUnitId
     *
     * @return mixed
     */
    public function findByFiscalYear(FiscalYear $fiscalYear, int $executingUnitId)
    {
        $query = ProjectFiscalYear::join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->where([
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['project_fiscal_years.fiscal_year_id', '=', $fiscalYear->id],
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED],
                ['plans.start_year', '<=', $fiscalYear->year],
                ['plans.end_year', '>=', $fiscalYear->year],
                ['projects.executing_unit_id', '=', $executingUnitId],
            ])
            ->select('project_fiscal_years.*')
            ->with([
                'project.subprogram.parent.parent',
                'project.indicators.planIndicatorGoals',
                'activitiesProjectFiscalYear' => function ($query) {
                    $query->with([
                        'tasks.responsible' => function ($query) {
                            $query->where('active', true);
                        },
                        'tasks' => function ($query) {
                            $query->where('type', Task::ELEMENT_TYPE['MILESTONE']);
                        }
                    ]);
                }
            ]);

        return $query->get();
    }

    /**
     * Obtiene información del reporte Comparativo entre planificado y devengado.
     *
     * @param int $fiscalYearId
     * @param int $executingUnit
     *
     * @return mixed
     */
    public function projectsInProgressPlanningAccruedData(int $fiscalYearId, int $executingUnit = 0)
    {
        return ProjectFiscalYear::join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->when($executingUnit != 0, function ($query) use ($executingUnit) {
                return $query->where('projects.executing_unit_id', $executingUnit);
            })
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->where([
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['project_fiscal_years.fiscal_year_id', '=', $fiscalYearId],
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED]
            ])
            ->select('project_fiscal_years.*')
            ->with([
                'project',
                'activitiesProjectFiscalYear' => function ($query) {
                    $query->whereNull('activity_project_fiscal_years.deleted_at')
                        ->select('activity_project_fiscal_years.*')
                        ->with([
                            'budgetItems' => function ($query) {
                                $query->select(DB::raw('budget_items.*,
                                                                budget_classifier_spendings.full_code, budget_classifier_spendings.title, budget_items.amount,
                                                                financing_source_classifiers.description,
                                                               (select sum(bp.assigned) from budget_plannings bp where (bp.month = 1 or bp.month = 2 or bp.month = 3)
                                                               and bp.budget_item_id = budget_items.id) as trim_1,
                                                               (select sum(bp.assigned) from budget_plannings bp where (bp.month = 4 or bp.month = 5 or bp.month = 6)
                                                               and bp.budget_item_id = budget_items.id) as trim_2,
                                                               (select sum(bp.assigned) from budget_plannings bp where (bp.month = 7 or bp.month = 8 or bp.month = 9)
                                                               and bp.budget_item_id = budget_items.id) as trim_3,
                                                               (select sum(bp.assigned) from budget_plannings bp where (bp.month = 10 or bp.month = 11 or bp.month = 12)
                                                               and bp.budget_item_id = budget_items.id) as trim_4'))
                                    ->join('budget_classifier_spendings', 'budget_items.budget_classifier_id', '=', 'budget_classifier_spendings.id')
                                    ->join('financing_source_classifiers', 'budget_items.financing_source_id', '=', 'financing_source_classifiers.id');
                            }
                        ]);
                }
            ])->get();
    }

    /**
     * Consulta información de projectos en el sistema financiero
     *
     * @param Collection $projectFiscalYears
     * @param $projectCodes
     * @param $year
     *
     * @return Collection
     * @throws Exception
     */
    public function getProjectBudgetProgress(Collection $projectFiscalYears, $projectCodes, $year)
    {
        $results = $this->apiFinancialService->getProjectBudgetProgressTrackingReportsRepositoryApi($year, $projectCodes);
        return $projectFiscalYears->map(function ($item) use ($results) {
            $item->setAttribute('trim_1', $item->activitiesProjectFiscalYear->sum(function ($act) {
                return $act->budgetItems->sum('trim_1');
            }));
            $item->setAttribute('trim_2', $item->activitiesProjectFiscalYear->sum(function ($act) {
                return $act->budgetItems->sum('trim_2');
            }));
            $item->setAttribute('trim_3', $item->activitiesProjectFiscalYear->sum(function ($act) {
                return $act->budgetItems->sum('trim_3');
            }));
            $item->setAttribute('trim_4', $item->activitiesProjectFiscalYear->sum(function ($act) {
                return $act->budgetItems->sum('trim_4');
            }));

            $project = $results->firstWhere('project_code', $item->project->getProgramSubProgramCode());
            if (!$project) {
                $item->setAttribute('accruedtrim_1', 0.00);
                $item->setAttribute('accruedtrim_2', 0.00);
                $item->setAttribute('accruedtrim_3', 0.00);
                $item->setAttribute('accruedtrim_4', 0.00);

                $item->setAttribute('budgetProgressTrim_1', 0.00);
                $item->setAttribute('budgetProgressTrim_2', 0.00);
                $item->setAttribute('budgetProgressTrim_3', 0.00);
                $item->setAttribute('budgetProgressTrim_4', 0.00);

                $item->setAttribute('indexTrim1', 0.00);
                $item->setAttribute('indexTrim1', 0.00);
                $item->setAttribute('indexTrim1', 0.00);
                return $item;
            }

            foreach ($project as $key => $value) {
                $item->setAttribute($key, $value);
            }

            $item->setAttribute('encoded', $item->assigned + $item->reform);
            $item->setAttribute('budgetExecutionProgress', self::getBudgetProgress($item->encoded, $item->accrued));

            $item->setAttribute('budgetProgressTrim_1', self::getBudgetProgress($item->trim_1, $item->accruedtrim_1));
            $item->setAttribute('budgetProgressTrim_2', self::getBudgetProgress($item->trim_2, $item->accruedtrim_2));
            $item->setAttribute('budgetProgressTrim_3', self::getBudgetProgress($item->trim_3, $item->accruedtrim_3));
            $item->setAttribute('budgetProgressTrim_4', self::getBudgetProgress($item->trim_4, $item->accruedtrim_4));

            $item->setAttribute('indexTrim1', $item->trim_1 != 0 ? ($item->accrued / $item->trim_1) : 0);
            $item->setAttribute('indexTrim1', ($item->trim_1 + $item->trim_2) != 0 ? ($item->accrued / ($item->trim_1 + $item->trim_2)) : 0);
            $item->setAttribute('indexTrim1', ($item->trim_1 + $item->trim_2 + $item->trim_3) != 0 ? ($item->accrued / ($item->trim_1 + $item->trim_2 + $item->trim_3)) : 0);

            return $item;
        });
    }

    /**
     * Calcular % avance presupuestario
     *
     * @param $planning
     * @param $accrued
     *
     * @return float
     */
    private function getBudgetProgress($planning, $accrued)
    {
        if ($planning) {
            return (float)number_format(($accrued * 100) / $planning, 2);
        } else {
            return 0.00;
        }
    }

    /**
     * Obtiene los movimientos financieros de una partida presupuestaria
     *
     * @param int $year
     * @param string $account
     *
     * @return Response
     * @throws Exception
     */
    public function budgetItemMovements(int $year, string $account): Response
    {
        return $this->apiFinancialService->budgetItemMovementsApi($year, $account);
    }

    /**
     * Obtiene información de una partida presupuestaria
     *
     * @param int $year
     * @param string $account
     *
     * @return Response
     * @throws Exception
     */
    public function getBudgetItemByAccount(int $year, string $account): Response
    {
        return $this->apiFinancialService->getBudgetItemByAccountApi($year, $account);
    }

    /**
     * Retorna las Tareas/Hitos
     *
     * @param FiscalYear $currentFiscalYear
     * @param array $filter
     *
     * @return mixed
     */
    public function findByFiscalYearFilterByUser(FiscalYear $currentFiscalYear, array $filter)
    {
        $query = Task::join('activity_project_fiscal_years', 'tasks.activity_project_fiscal_year_id', '=', 'activity_project_fiscal_years.id')
            ->join('project_fiscal_years', 'project_fiscal_years.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->join('departments', 'projects.responsible_unit_id', '=', 'departments.id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->whereNull('tasks.deleted_at')
            ->where([
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED],
                ['plans.start_year', '<=', $currentFiscalYear->year],
                ['plans.end_year', '>=', $currentFiscalYear->year],
                ['project_fiscal_years.fiscal_year_id', '=', $currentFiscalYear->id],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS]
            ])
            ->when($filter['status'] != Task::ALL, function ($query) use ($filter) {
                if ($filter['status'] == Task::STATUS_DELAYED) {
                    $query->where([
                        ['tasks.status', '=', Task::STATUS_PENDING],
                        ['tasks.date_end', '<', Carbon::now()]
                    ]);
                } elseif ($filter['status'] == Task::STATUS_PENDING) {
                    $query->where([
                        ['tasks.status', '=', Task::STATUS_PENDING],
                        ['tasks.date_end', '>=', Carbon::now()]
                    ]);
                } else {
                    $query->where('tasks.status', '=', $filter['status']);
                }
            })
            ->whereNotIn('tasks.status', [Task::STATUS_COMPLETED_ONTIME, Task::STATUS_COMPLETED_OUTOFTIME])
            ->select('tasks.*', 'projects.name as project_name', 'departments.name as responsibleUnit', 'activity_project_fiscal_years.name as activity')
            ->with([
                'responsible' => function ($query) {
                    $query->where('active', true);
                }
            ]);

        return $query;
    }

    /**
     * Retorna los Presupuestos participativos
     *
     * @param FiscalYear $fiscalYear
     *
     * @return mixed
     * @throws Exception
     */
    public function participatoryBudgetData(FiscalYear $fiscalYear)
    {
        $budgetItemsFromOperationalActivities = BudgetItem::join('operational_activities', 'operational_activities.id', '=', 'budget_items.operational_activity_id')
            ->join('current_expenditure_elements', 'operational_activities.current_expenditure_element_id', 'current_expenditure_elements.id')
            ->where('budget_items.fiscal_year_id', $fiscalYear->id)
            ->where('is_participatory_budget', true)
            ->select('budget_items.*')
            ->with([
                'budgetClassifier',
                'geographicLocation'
            ]);

        $budgetItems = BudgetItem::join('activity_project_fiscal_years', 'activity_project_fiscal_years.id', '=', 'budget_items.activity_project_fiscal_year_id')
            ->join('project_fiscal_years', 'project_fiscal_years.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->where([
                ['budget_items.fiscal_year_id', '=', $fiscalYear->id],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED]
            ])
            ->where('budget_items.fiscal_year_id', $fiscalYear->id)
            ->where('is_participatory_budget', true)
            ->with([
                'budgetClassifier',
                'geographicLocation'
            ])
            ->select('budget_items.*')
            ->union($budgetItemsFromOperationalActivities)
            ->get();

        $sfgprov = json_decode($this->settingRepository->findByKey('gad'))->value->sfgprov;
        if ($sfgprov->exist) {
            return self::remoteTotalsBudgetItem($budgetItems, $fiscalYear);
        } else {
            throw new Exception(trans('reports.exceptions.finance_system_not_found'), 1000);
        }
    }

    /**
     * Consulta el información agrupada de las partidas presupuestarias en la base de datos del sistema financiero
     *
     * @param Collection $budgetItems
     * @param FiscalYear $fiscalYear
     *
     * @return Collection
     * @throws Exception
     */
    public function remoteTotalsBudgetItem(Collection $budgetItems, FiscalYear $fiscalYear)
    {
        $sfgprov = json_decode($this->settingRepository->findByKey('gad'))->value->sfgprov;
        $params = [$sfgprov->company_code, $fiscalYear->year];
        $codes = $budgetItems->pluck('code');
        $bindingsString = trim(str_repeat('?,', count($codes)), ',');
        if ($bindingsString === "") {
            $bindingsString = "''";
        }
        $params = array_merge($params, $codes->toArray());
        $financeBudgetItems = api_available() ? $this->apiFinancialService->remoteTotalsBudgetItemTrackingReportsRepositoryApi($bindingsString, $params) : collect([]);
        return $budgetItems->map(function ($item) use ($financeBudgetItems) {
            $bi = $financeBudgetItems->firstWhere('cuenta', $item->code);
            if (!$bi) {
                $item->setAttribute('assigned', 0);
                $item->setAttribute('total_reform', 0);
                $item->setAttribute('total_accrued', 0);
                $item->setAttribute('encoded', 0);
                return $item;
            }
            foreach ($bi as $key => $value) {
                $item->setAttribute($key, $value);
            }
            $item->setAttribute('encoded', $item->assigned + $item->total_reform);

            return $item;
        });
    }

    /**
     * Obtiene los niveles de la estructura de Ingreso o Gasto
     *
     * @param int $year
     * @param int $type
     *
     * @return Response
     * @throws Exception
     */
    public function structureLevelsByLevels(int $year, int $type = 1) // 1 => Tipo Gasto
    {
        return $this->apiFinancialService->structureLevelsByLevelsApi($year, $type);
    }

    /**
     * Obtiene información presupuestaria de las partidas
     *
     * @param int $year
     * @param string $date
     *
     * @return Response
     * @throws Exception
     */
    public function budgetCardExpenses(int $year, string $date)
    {
        return $this->apiFinancialService->budgetCardExpensesApi($year);
    }

    /**
     * Obtener infomación del reporte pac
     *
     * @param int $fiscalYearId
     *
     * @return BudgetItem[]|Builder[]|Collection
     */
    public function pacReport(int $fiscalYearId)
    {
        $operationalActivities = PublicPurchase::join('budget_items', 'budget_items.id', 'public_purchases.budget_item_id')
            ->join('operational_activities', 'budget_items.operational_activity_id', 'operational_activities.id')
            ->join('current_expenditure_elements', 'operational_activities.current_expenditure_element_id', 'current_expenditure_elements.id')
            ->where('budget_items.fiscal_year_id', $fiscalYearId)
            ->select('public_purchases.*')
            ->with([
                'cpcClassifier',
                'procedure',
                'budgetItem.budgetClassifier',
                'budgetItem.geographicLocation',
                'budgetItem.source',
                'budgetItem.institution',
                'budgetItem.operationalActivity.subprogram.parent.area',
                'budgetItem.operationalActivity.responsibleUnit',
                'budgetItem.operationalActivity.executingUnit'
            ]);

        return PublicPurchase::join('budget_items', 'budget_items.id', 'public_purchases.budget_item_id')
            ->join('activity_project_fiscal_years', 'budget_items.activity_project_fiscal_year_id', 'activity_project_fiscal_years.id')
            ->join('project_fiscal_years', 'activity_project_fiscal_years.project_fiscal_year_id', 'project_fiscal_years.id')
            ->join('projects', 'project_fiscal_years.project_id', 'projects.id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->where([
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED],
                ['budget_items.fiscal_year_id', '=', $fiscalYearId],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS]
            ])
            ->select('public_purchases.*')
            ->with([
                'cpcClassifier',
                'procedure',
                'budgetItem.budgetClassifier',
                'budgetItem.geographicLocation',
                'budgetItem.source',
                'budgetItem.institution',
                'budgetItem.activityProjectFiscalYear.area',
                'budgetItem.activityProjectFiscalYear.projectFiscalYear',
                'budgetItem.activityProjectFiscalYear.component.project.responsibleUnit',
                'budgetItem.activityProjectFiscalYear.component.project.executingUnit',
                'budgetItem.activityProjectFiscalYear.component.project.subprogram.parent',
            ])
            ->union($operationalActivities)
            ->get();
    }

    /**
     * Obtiene los proyectos en ejecución
     *
     * @param int $fiscal_year_id
     *
     * @param string $date
     *
     * @return mixed
     */
    public function getExecutionProjects(int $fiscal_year_id, string $date)
    {
        return ProjectFiscalYear::join('projects as p', 'p.id', '=', 'project_fiscal_years.project_id')
            ->join('departments', 'departments.id', '=', 'p.executing_unit_id')
            ->whereNull('p.deleted_at')
            ->where([
                'project_fiscal_years.fiscal_year_id' => $fiscal_year_id,
                'project_fiscal_years.status' => ProjectFiscalYear::STATUS_IN_PROGRESS,
            ])
            ->select(
                'departments.name as executingUnit',
                'departments.code as executingUnitCode',
                'p.name as project_name',
                'project_fiscal_years.id as id',
                'project_fiscal_years.project_id as project_id'
            )
            ->with([
                'project.subprogram.parent',
                'activitiesProjectFiscalYear.tasks' => function ($q) use ($date) {
                    return $q->where(function ($q) use ($date) {
                        $q->where('tasks.date_end', '<=', DateTime::createFromFormat('!d-m-Y', $date))
                            ->orWhere('tasks.due_date', '<=', DateTime::createFromFormat('!d-m-Y', $date));
                    });
                }
            ])
            ->orderBy('departments.name')
            ->get();
    }

    /**
     * Obtiene los proyectos en ejecución
     *
     * @param int $fiscal_year_id
     *
     * @return mixed
     */
    public function getExecutionProjectsAdvanceInvestmentProjects(int $fiscal_year_id)
    {
        return ProjectFiscalYear::join('projects as p', 'p.id', '=', 'project_fiscal_years.project_id')
            ->join('departments', 'departments.id', '=', 'p.executing_unit_id')
            ->whereNull('p.deleted_at')
            ->where([
                'project_fiscal_years.fiscal_year_id' => $fiscal_year_id,
                'project_fiscal_years.status' => ProjectFiscalYear::STATUS_IN_PROGRESS,
            ])
            ->select(
                'departments.name as executingUnit',
                'p.name as project_name',
                'project_fiscal_years.id as id',
                'project_fiscal_years.project_id as project_id'
            )
            ->with(['project.subprogram.parent', 'activitiesProjectFiscalYear'])
            ->orderBy('departments.name')
            ->get();
    }

    /**
     * Obtiene presupuesto por categoría
     *
     * @param int $year
     * @param string $date
     * @param int $from
     * @param int $length
     * @param int $level
     *
     * @return Response
     * @throws Exception
     */
    public function progressExecutionProgress(int $year, string $date, int $from, int $length, int $level)
    {
        return $this->apiFinancialService->progressExecutionProgressApi($year, $from, $length, $level);
    }

    /**
     * Retorna las Tareas/Hitos
     *
     * @param array $filters
     *
     * @return mixed
     */
    public function findTasksByFilters(array $filters)
    {
        return Task::join('activity_project_fiscal_years', 'tasks.activity_project_fiscal_year_id', '=', 'activity_project_fiscal_years.id')
            ->join('project_fiscal_years', 'project_fiscal_years.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->join('departments', 'projects.responsible_unit_id', '=', 'departments.id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->where([
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED],
                ['project_fiscal_years.fiscal_year_id', '=', $filters['fiscal_year_id']],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS]
            ])
            ->when(isset($filters['fiscal_year_id']), function ($query) use ($filters) {
                $query->where('project_fiscal_years.fiscal_year_id', $filters['fiscal_year_id']);
            })
            ->when(isset($filters['responsible_unit_id']), function ($query) use ($filters) {
                $query->where('projects.responsible_unit_id', $filters['responsible_unit_id']);
            })
            ->when(isset($filters['project_fiscal_year_id']), function ($query) use ($filters) {
                $query->where('project_fiscal_years.id', $filters['project_fiscal_year_id']);
            })
            ->when(isset($filters['date_init']), function ($query) use ($filters) {
                $query->where('tasks.date_init', '>=', DateTime::createFromFormat('!d-m-Y', $filters['date_init']));
            })
            ->when(isset($filters['date_end']), function ($query) use ($filters) {
                $query->orWhere(function ($q) use ($filters) {
                    $q->where('tasks.date_end', '<=', DateTime::createFromFormat('!d-m-Y', $filters['date_end']))
                        ->orWhere('tasks.due_date', '<=', DateTime::createFromFormat('!d-m-Y', $filters['date_end']));
                });
            })
            ->when(isset($filters['assigned_user_id']), function ($query) use ($filters) {
                $query->join('users_manages_tasks', 'users_manages_tasks.task_id', '=', 'tasks.id');
                $query->where(function ($query) use ($filters) {
                    $query->orWhere('users_manages_tasks.user_id', $filters['assigned_user_id']);
                });
            })
            ->select('tasks.*', 'projects.name as project_name')
            ->with([
                'responsible' => function ($query) {
                    $query->where('active', true);
                },
                'files'
            ]);
    }

    /**
     * Obtener infomación del reporte de reformas y certificaciones
     *
     * @param $projectFiscalYear
     * @param $fiscalYear
     *
     * @return BudgetItem[]|Builder[]|Collection
     * @throws Exception
     */
    public function reformAndCertificationReport($projectFiscalYear, $fiscalYear)
    {

        $budgetItems = BudgetItem::selectRaw('budget_items.*,
                           (select bp.assigned from budget_plannings bp where bp.month = 1 and bp.budget_item_id = budget_items.id) as jan,
                           (select bp.assigned from budget_plannings bp where bp.month = 2 and bp.budget_item_id = budget_items.id) as feb,
                           (select bp.assigned from budget_plannings bp where bp.month = 3 and bp.budget_item_id = budget_items.id) as mar,
                           (select bp.assigned from budget_plannings bp where bp.month = 4 and bp.budget_item_id = budget_items.id) as apr,
                           (select bp.assigned from budget_plannings bp where bp.month = 5 and bp.budget_item_id = budget_items.id) as may,
                           (select bp.assigned from budget_plannings bp where bp.month = 6 and bp.budget_item_id = budget_items.id) as jun,
                           (select bp.assigned from budget_plannings bp where bp.month = 7 and bp.budget_item_id = budget_items.id) as jul,
                           (select bp.assigned from budget_plannings bp where bp.month = 8 and bp.budget_item_id = budget_items.id) as aug,
                           (select bp.assigned from budget_plannings bp where bp.month = 9 and bp.budget_item_id = budget_items.id) as sep,
                           (select bp.assigned from budget_plannings bp where bp.month = 10 and bp.budget_item_id = budget_items.id) as oct,
                           (select bp.assigned from budget_plannings bp where bp.month = 11 and bp.budget_item_id = budget_items.id) as nov,
                           (select bp.assigned from budget_plannings bp where bp.month = 12 and bp.budget_item_id = budget_items.id) as december')
            ->join('activity_project_fiscal_years', 'activity_project_fiscal_years.id', '=', 'budget_items.activity_project_fiscal_year_id')
            ->join('project_fiscal_years', 'project_fiscal_years.id', '=', 'activity_project_fiscal_years.project_fiscal_year_id')
            ->join('projects', 'projects.id', '=', 'project_fiscal_years.project_id')
            ->join('plan_elements', 'plan_elements.id', '=', 'projects.plan_element_id')
            ->join('plans', 'plans.id', '=', 'plan_elements.plan_id')
            ->whereNull('projects.deleted_at')
            ->whereNull('plan_elements.deleted_at')
            ->whereNull('plans.deleted_at')
            ->whereNull('activity_project_fiscal_years.deleted_at')
            ->where([
                ['project_fiscal_years.id', '=', $projectFiscalYear->id],
                ['budget_items.fiscal_year_id', '=', $fiscalYear->id],
                ['project_fiscal_years.status', '=', ProjectFiscalYear::STATUS_IN_PROGRESS],
                ['plans.type', '=', Plan::TYPE_PEI],
                ['plans.status', '=', Plan::STATUS_APPROVED]
            ])
            ->with([
                'geographicLocation',
                'activityProjectFiscalYear.component.project',
            ])->get();

        $sfgprov = json_decode($this->settingRepository->findByKey('gad'))->value->sfgprov;
        if ($sfgprov->exist) {
            return self::remoteTotalsBudgetItem($budgetItems, $fiscalYear);
        } else {
            throw new Exception(trans('reports.exceptions.finance_system_not_found'), 1000);
        }
    }
}
