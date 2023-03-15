<?php
declare(strict_types=1);

namespace App\Services;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ApiFinancialService
{
    /**
     * @var string|null
     */
    protected static ?string $baseUrl = null;

    /**
     * @return string|null
     */
    public static function baseUrl()
    {
        if (!isset(static::$baseUrl)) {
            static::$baseUrl = api_url();
        }
        return static::$baseUrl;
    }


    /**
     * @param $year
     * @return array|object
     * @throws Exception
     */
    public function activitiesBudgetApi($year)
    {
        try {
            $response = Http::get(static::baseUrl() . '/budget/activitiesBudget', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function activitiesBudgetProjectApi($year)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/activitiesBudgetProject', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $activitiesCodes
     * @return array|object
     * @throws Exception
     */
    public function getActivitiesBudgetApi($year, $activitiesCodes)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getActivitiesBudget', [
                'year' => $year,
                'activitiesCodes' => $activitiesCodes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $param
     * @param $codes
     * @param $from
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getIndicatorBudgetApi($param, $codes, $from)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getIndicatorBudget', [
                'param' => $param,
                'codes' => $codes,
                'from' => $from,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $param
     * @param $codes
     * @param $from
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function totalsByYearApi($year)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/totalsByYear', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }


    /**
     * @param $year
     * @param $projectCodes
     * @param $filterByProject
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getProjectBudgetApi($year, $projectCodes)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getProjectBudget', [
                'year' => $year,
                'projectCodes' => $projectCodes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $bindingsString
     * @param $params
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetCardExpensesItemBusinessRepositoryApi($params, $bindingsString)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetCardExpensesItemBusinessRepository', [
                'bindingsString' => $bindingsString,
                'params' => $params,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $from
     * @param $length
     * @param $level
     * @param $type
     * @param $projectCode
     * @return Response
     * @throws Exception
     */
    public function activitiesProjectEncodedApi($year, $from, $length, $level, $type, $projectCode)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/activitiesProjectEncoded', [
                'year' => $year,
                'from' => $from,
                'length' => $length,
                'level' => $level,
                'type' => $type,
                'projectCode' => $projectCode,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $projectCodes
     * @return Response
     * @throws Exception
     */
    public function findProjectsWithReformsApi($year, $projectCodes)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/findProjectsWithReforms', [
                'year' => $year,
                'projectCodes' => $projectCodes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $type
     * @return Response
     * @throws Exception
     */
    public function totalsBudgetByTypeApi($year, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/totalsBudgetByType', [
                'year' => $year,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $from
     * @param $length
     * @param $level
     * @param $type
     * @return array|object
     * @throws Exception
     */
    public function budgetByCategoryApi($year, $from, $length, $level, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetByCategory', [
                'year' => $year,
                'from' => $from,
                'length' => $length,
                'level' => $level,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetMonthlyExecutionApi($year)
    {
        try {
            $response = Http::get(static::baseUrl() . '/budget/budgetMonthlyExecution', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $type
     * @return Response
     * @throws Exception
     */
    public function totalsProjectByTypeApi($year, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/totalsProjectByType', [
                'year' => $year,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @return Response
     * @throws Exception
     */
    public function projectMonthlyExecutionApi($year)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/projectMonthlyExecution', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $from
     * @param $length
     * @param $level
     * @param $type
     * @return Response
     * @throws Exception
     */
    public function projectByCategoryApi($year, $from, $length, $level, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/projectByCategory', [
                'year' => $year,
                'from' => $from,
                'length' => $length,
                'level' => $level,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $itemType
     * @param $level
     * @param $operator
     * @param $allItems
     * @param $item
     * @param $executingUnit
     * @return array|object
     * @throws Exception
     */
    public function budgetCardApi($year, $itemType, $level, $operator, $allItems, $item, $executingUnit)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetCard', [
                'year' => $year,
                'itemType' => $itemType,
                'level' => $level,
                'operator' => $operator,
                'allItems' => $allItems,
                'item' => $item,
                'executingUnit' => $executingUnit,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $itemType
     * @param $level
     * @param $allItems
     * @param $item
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetCard2Api($year, $itemType, $level, $allItems, $item)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetCard2', [
                'year' => $year,
                'itemType' => $itemType,
                'level' => $level,
                'allItems' => $allItems,
                'item' => $item,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $type
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function structureLevelsApi($year, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/structureLevels', [
                'year' => $year,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $projectCodes
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getProjectBudgetProgressTrackingReportsRepositoryApi($year, $projectCodes)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getProjectBudgetProgressTrackingReportsRepository', [
                'year' => $year,
                'projectCodes' => $projectCodes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $account
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetItemMovementsApi($year, $account)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetItemMovements', [
                'year' => $year,
                'account' => $account,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $account
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getBudgetItemByAccountApi($year, $account)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getBudgetItemByAccount', [
                'year' => $year,
                'account' => $account,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $params
     * @param $filter
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function remoteTotalsBudgetItemTrackingRepositoryApi($params, $codes)
    {
        try {
            //TODO REVISAR DONDE SE PONE EL API_AVAILABLE()
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/remoteTotalsBudgetItemTrackingRepository', [
                'params' => $params,
                'codes' => $codes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $type
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function structureLevelsByLevelsApi($year, $type)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/structureLevelsByLevels', [
                'year' => $year,
                'type' => $type,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function budgetCardExpensesApi($year)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/budgetCardExpenses', [
                'year' => $year,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $from
     * @param $length
     * @param $level
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function progressExecutionProgressApi($year, $from, $length, $level)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/progressExecutionProgress', [
                'year' => $year,
                'from' => $from,
                'length' => $length,
                'level' => $level,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $bindingsString
     * @param $filter
     * @param $params
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function remoteTotalsBudgetItemTrackingReportsRepositoryApi($bindingsString, $params)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/remoteTotalsBudgetItemTrackingReportsRepository', [
                'bindingsString' => $bindingsString,
                'params' => $params,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $select
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function remoteBudgetItemApi($year, $select)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/remoteBudgetItem', [
                'year' => $year,
                'select' => $select,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $projectCodes
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getProjectBudgetProgressRepositoryBusinessTrackingApi($year, $projectCodes)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getProjectBudgetProgressRepositoryBusinessTracking', [
                'year' => $year,
                'projectCodes' => $projectCodes,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $params
     * @param $data
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getOperationByTypeAndYearApi($data)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getOperationByTypeAndYear', [
                'data' => $data,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $operationType
     * @param $operationNumber
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function findReformApi($year, $operationType, $operationNumber)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/findReform', [
                'year' => $year,
                'operationType' => $operationType,
                'operationNumber' => $operationNumber,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $operationType
     * @param $operationNumber
     * @param $withBalance
     * @param $state_approved
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function findReformDetailsApi($year, $operationType, $operationNumber, $withBalance, $state_approved)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/findReformDetails', [
                'year' => $year,
                'operationType' => $operationType,
                'operationNumber' => $operationNumber,
                'withBalance' => $withBalance,
                'state_approved' => $state_approved,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $data
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function findAllBudgetItemsApi($year, $data)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/findAllBudgetItems', [
                'year' => $year,
                'data' => $data,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $year
     * @param $period
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function findAccountingPeriodApi($year, $period)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/findAccountingPeriod', [
                'year' => $year,
                'period' => $period,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }


    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getFiscalYearApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getFiscalYear', [
                'fiscalYear' => $fiscalYear,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $budgetItems
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function remotePOAQueryApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/remotePOAQuery', [
                'fiscalYear' => $fiscalYear,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function proformaExistsApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/proformaExists', [
                'fiscalYear' => $fiscalYear,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getCodifiedIncomesApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getCodifiedIncomes', [
                'fiscalYear' => $fiscalYear,
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getCodifiedExpensesApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getCodifiedExpenses', [
                'fiscalYear' => $fiscalYear
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getProformaIncomesApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getProformaIncomes', [
                'fiscalYear' => $fiscalYear
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return \Illuminate\Support\Collection
     * @throws Exception
     */
    public function getProformaExpensesApi($fiscalYear)
    {
        try {
            $response = Http::timeout(3)->get(static::baseUrl() . '/budget/getProformaExpenses', [
                'fiscalYear' => $fiscalYear
            ]);
            if ($response->ok()) {
                return $response->object();
            } else {
                throw new Exception('Error' . $response->status());
            }
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function createReformApi($fiscalYear, $userCode)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/createReform', [
                'fiscalYear' => $fiscalYear,
                'userCode' => $userCode,
            ]);

        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function syncProformaApi($proformas, $operation, $operationDetails)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/syncProforma', [
                'proformas' => $proformas,
                'operation' => $operation,
                'operationDetails' => $operationDetails,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function insertDetailsCertificationApi($entity, $reform, $userCode)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/insertDetailsCertification', [
                'entity' => $entity,
                'reform' => $reform,
                'userCode' => $userCode,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function syncStructureApi($structure, $currentCode, $year)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/syncStructure', [
                'structure' => $structure,
                'currentCode' => $currentCode,
                'year' => $year,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function insertDetailsApi($details, $reform, $userCode, $period, $sec_det, $currentDate)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/insertDetails', [
                'details' => $details,
                'reform' => $reform,
                'userCode' => $userCode,
                'period' => $period,
                'sec_det' => $sec_det,
                'currentDate' => $currentDate,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function updateReformApi($reform)
    {
        try {
            Http::retry(3, 100)->put(static::baseUrl() . '/budget/updateReform', [
                'reform' => $reform,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function updateDetailsApi($updateDetails, $reform)
    {
        try {
            Http::retry(3, 100)->put(static::baseUrl() . '/budget/updateDetails', [
                'updateDetails' => $updateDetails,
                'reform' => $reform,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function deleteDetailsApi($sec_det, $reform)
    {
        try {
            Http::retry(3, 100)->delete(static::baseUrl() . '/budget/deleteDetails', [
                'sec_det' => $sec_det,
                'reform' => $reform,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function updateStatusReformApi($reform)
    {
        try {
            Http::retry(3, 100)->put(static::baseUrl() . '/budget/updateStatusReform', [
                'reform' => $reform,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function createReformCertificationApi($fiscalYear, $userCode, $certification)
    {
        try {
            Http::retry(3, 100)->post(static::baseUrl() . '/budget/createReformCertification', [
                'reform' => $fiscalYear,
                'userCode' => $userCode,
                'certification' => $certification,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }

    /**
     * @param $fiscalYear
     * @return Response
     * @throws Exception
     */
    public function destroyProformaRepositoryApi($year, $userCode, $certification)
    {
        try {
            Http::retry(3, 100)->delete(static::baseUrl() . '/budget/destroyProformaRepository', [
                'year' => $year,
            ]);
        } catch (RequestException $exception) {
            throw  new Exception($exception->getMessage(), 500);
        }
    }
}
