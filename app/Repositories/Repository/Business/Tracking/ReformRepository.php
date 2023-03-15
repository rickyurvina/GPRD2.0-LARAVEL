<?php

namespace App\Repositories\Repository\Business\Tracking;

use App\Models\Business\Certification;
use App\Models\Business\Planning\FiscalYear;
use App\Models\Business\Tracking\Operation;
use App\Models\Business\Tracking\OperationDetail;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use stdClass;
use Throwable;

/**
 * Clase ReformRepository
 * @package App\Repositories\Repository\Business\Tracking
 */
class ReformRepository
{
    const OPERATION_STATE_APPROVED = 'APROBADO';
    const OPERATION_STATE_SQUARE = 'CUADRADO';
    const OPERATION_STATE_DRAFT = 'DIGITADO';
    const OPERATION_STATE_APPROVED_3 = 3;
    const OPERATION_STATE_SQUARE_2 = 2;
    const OPERATION_STATE_DRAFT_1 = 1;

    const REFORMS_TYPE_TRANSFER = 'TRASPASO';
    const REFORMS_TYPE_INCREASE = 'INCREMENTO';
    const REFORMS_TYPE_DECREASE = 'DISMINUCIÓN';
    const REFORMS_TYPE_TRANSFER_0 = 0;
    const REFORMS_TYPE_INCREASE_1 = 1;
    const REFORMS_TYPE_DECREASE_2 = 2;

    const BUDGET_ITEM_INCOME = 2;
    const BUDGET_ITEM_EXPENSE = 1;

    const MOV_REFORM_TYPE = 'RE';
    const MOV_CERTIFICATION_TYPE = 'CE';

    private $apiFinancialService;

    /**
     * Constructor de BudgetProjectTrackingRepository.
     *
     * @param SettingRepository $settingRepository
     */
    public function __construct(ApiFinancialService $apiFinancialService)
    {
        $this->apiFinancialService = $apiFinancialService;
    }

    /**
     * Buscar operaciones por tipo y año fiscal
     *
     * @param int $year
     * @param string $type
     * @param string $company_code
     * @param array $data
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    public function getOperationByTypeAndYear(int $year, string $type, string $company_code, array $data)
    {
        return api_available() ? $this->apiFinancialService->getOperationByTypeAndYearApi($data) : collect([]);
    }

    /**
     * Buscar una reforma
     *
     * @param string $companyCode
     * @param int $year
     * @param string $operationType
     * @param int $operationNumber
     * @param bool $withBalance
     *
     * @return stdClass
     * @throws Exception
     */
    public function findReform(string $companyCode, int $year, string $operationType, int $operationNumber, bool $withBalance = false)
    {
        $result = api_available() ? $this->apiFinancialService->findReformApi($year, $operationType, $operationNumber) : collect([]);
        if (!isset($result[0])) {
            throw new Exception();
        } else {
            $reform = $result[0];
        }
        // find reform details
        $reform->details = self::findReformDetails($companyCode, $year, $operationType, $operationNumber, $withBalance);
        return $reform;
    }

    /**
     * Buscar detalles de una operación
     *
     * @param string $companyCode
     * @param int $year
     * @param string $operationType
     * @param int $operationNumber
     * @param bool $withBalance
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    public function findReformDetails(string $companyCode, int $year, string $operationType, int $operationNumber, bool $withBalance = false)
    {
        $state_approved = self::OPERATION_STATE_APPROVED_3;
        return api_available() ? $this->apiFinancialService->findReformDetailsApi($year, $operationType, $operationNumber, $withBalance, $state_approved) : collect([]);
    }

    /**
     * Buscar partidas presupuestarias
     *
     * @param int $year
     * @param string $companyCode
     * @param array $data
     *
     * @return \Illuminate\Http\Client\Response
     * @throws Exception
     */
    public function findAllBudgetItems(int $year, string $companyCode, array $data)
    {
        return api_available() ? $this->apiFinancialService->findAllBudgetItemsApi($year, $data) : collect([]);
    }

    /**
     * Crea reforma presupuestaria
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     * @param string $userCode
     *
     * @return array
     * @throws Throwable
     */
    public function createReform(FiscalYear $fiscalYear, string $companyCode, string $userCode)
    {
        $response = [];
        if (api_available()) {
            $response = $this->apiFinancialService->createReformApi($fiscalYear->year, $userCode);
        }
        Operation::firstOrCreate(
            [
                'company_code' => $companyCode,
                'year' => $fiscalYear->year,
                'voucher_type' => $response['sig_tip'],
                'number' => $response['acu_tip'][0]->acu_tip,
                'description' => '',
                'total_debit' => 0,
                'total_credit' => 0,
                'created_by' => $userCode,
                'status' => $response['state'],
                'period' => $response['period'],
                'date_assignment' => Carbon::now(),
                'date_approval' => Carbon::now(),
                'date_created' => Carbon::now()
            ]);
        return $response['reform'];
    }

    /**
     * Actualizar una reforma presupuestaria
     *
     * @param array $reform
     * @param string $userCode
     *
     * @throws Throwable
     */
    public function updateReform(array $reform, string $userCode)
    {
        // Update reform in table prcabmov
        if (api_available()) {
            $this->apiFinancialService->updateReformApi($reform);
        }
        $operation = Operation::where([
            ['company_code', '=', $reform['codemp']],
            ['year', '=', $reform['anio']],
            ['voucher_type', '=', $reform['sig_tip']],
            ['number', '=', $reform['acu_tip']],
        ])->first();

        if ($operation) {
            $operation->date_assignment = $reform['fec_asi'];
            $operation->date_approval = $reform['fec_apr'];
            $operation->status = $reform['estado'];
            $operation->period = $reform['periodo'];
            $operation->total_debit = $reform['tot_deb'];
            $operation->total_credit = $reform['tot_cre'];
            $operation->voucher_type = $reform['sig_tip'];
            $operation->number = $reform['acu_tip'];
            $operation->description = $reform['des_cab'];
            $operation->save();
        } else {
            Operation::create(
                [
                    'company_code' => $reform['codemp'],
                    'year' => $reform['anio'],
                    'voucher_type' => $reform['sig_tip'],
                    'number' => $reform['acu_tip'],
                    'date_assignment' => $reform['fec_asi'],
                    'date_approval' => $reform['fec_apr'],
                    'status' => $reform['estado'],
                    'period' => $reform['periodo'],
                    'total_debit' => $reform['tot_deb'],
                    'total_credit' => $reform['tot_cre'],
                    'description' => $reform['des_cab'],
                    'date_created' => $reform['fec_cre'],
                    'created_by' => $reform['cre_por']
                ]
            );
        }

        // Update Reform details
        $currentDate = now()->format('Y-m-d');
        $period = now()->month;
        $sec_det = 0;

        // find reform details
        $details = self::findReformDetails($reform['codemp'], $reform['anio'], $reform['sig_tip'], $reform['acu_tip']);

        if ($details->count()) {
            $sec_det = $details->last()->sec_det;

            $newDetails = collect([]);
            $updateDetails = collect([]);

            $reform['budget_items']->each(function ($item, $key) use (&$details, $updateDetails, $newDetails) {
                if (!isset($item['sec_det'])) {
                    $newDetails->push($item);
                } else {
                    $updateDetails->push($item);
                    $details = $details->reject(function ($value, $key) use ($item) {
                        return $value->sec_det == $item['sec_det'];
                    });
                }
            });
            if ($updateDetails->count()) {
                self::updateDetails($updateDetails, $reform);
            }
            if ($details->count()) {
                self::deleteDetails($details->pluck('sec_det')->toArray(), $reform);
            }
            if ($newDetails->count()) {
                self::insertDetails($newDetails, $reform, $userCode, $currentDate, $period, $sec_det);
            }

        } else { // all details are new
            self::insertDetails($reform['budget_items'], $reform, $userCode, $currentDate, $period, $sec_det);
        }


    }

    /**
     * Crear nuevos detalles de la reforma
     *
     * @param Collection $details
     * @param array $reform
     * @param string $userCode
     * @param string $currentDate
     * @param int $period
     * @param int $sec_det
     * @throws Exception
     */
    private function insertDetails(Collection $details, array $reform, string $userCode, string $currentDate, int $period, int $sec_det)
    {
        foreach ($details as $item) {
            $sec_det++;
            OperationDetail::create([
                'company_code' => $reform['codemp'],
                'year' => $reform['anio'],
                'voucher_type' => $reform['sig_tip'],
                'number' => $reform['acu_tip'],
                'sequential' => $sec_det,
                'code' => $item['cuenta'],
                'income_amount' => $item['val_deb'],
                'expense_amount' => $item['val_cre'],
                'type' => $item['asociac'],
                'status' => $reform['estado'],
                'period' => $period,
                'created_by' => $userCode
            ]);
        }
        if (api_available()) {
            $this->apiFinancialService->insertDetailsApi($details, $reform, $userCode, $period, $sec_det, $currentDate);
        }

    }

    /**
     * Actualiza los detalles de una reforma
     *
     * @param Collection $updateDetails
     * @param array $reform
     * @throws Exception
     */
    private function updateDetails(Collection $updateDetails, array $reform)
    {
        $values = '';
        foreach ($updateDetails as $item) {
            $values .= "('{$reform['codemp']}', {$reform['anio']}, '{$reform['sig_tip']}', {$reform['acu_tip']}, {$item['sec_det']}, {$item['val_deb']}, {$item['val_cre']}), ";
            $detail = OperationDetail::where([
                ['company_code', '=', $reform['codemp']],
                ['year', '=', $reform['anio']],
                ['voucher_type', '=', $reform['sig_tip']],
                ['number', '=', $reform['acu_tip']],
                ['sequential', '=', $item['sec_det']],
            ])->first();

            if ($detail) {
                $detail->voucher_type = $reform['sig_tip'];
                $detail->number = $reform['acu_tip'];
                $detail->sequential = $item['sec_det'];
                $detail->income_amount = $item['val_deb'];
                $detail->expense_amount = $item['val_cre'];

                $detail->save();
            } else {
                OperationDetail::create(
                    [
                        'company_code' => $reform['codemp'],
                        'year' => $reform['anio'],
                        'voucher_type' => $reform['sig_tip'],
                        'number' => $reform['acu_tip'],
                        'sequential' => $item['sec_det'],
                        'code' => $item['cuenta'],
                        'income_amount' => $item['val_deb'],
                        'expense_amount' => $item['val_cre'],
                        'type' => $item['asociac'],
                        'status' => $reform['estado'],
                        'period' => $reform['periodo'],
                        'created_by' => $reform['cre_por']
                    ]
                );
            }
        }
        $values = rtrim($values, ', ');
        if (api_available()) {
            $this->apiFinancialService->updateDetailsApi($updateDetails, $reform);
        }
    }

    /**
     * Elimina detalles de una reforma
     *
     * @param array $sec_det
     * @param array $reform
     * @throws Exception
     */
    private function deleteDetails(array $sec_det, array $reform)
    {
        if (api_available()) {
            $this->apiFinancialService->deleteDetailsApi($sec_det, $reform);
        }

        $details = OperationDetail::where([
            ['year', '=', $reform['anio']],
            ['voucher_type', '=', $reform['sig_tip']],
            ['number', '=', $reform['acu_tip']]
        ])->whereIn('sequential', $sec_det)->get();

        foreach ($details as $detail) {
            $detail->delete();
        }
    }

    /**
     * Actualiza estados de una reforma presupuestaria
     *
     * @param stdClass $reform
     *
     * @throws Throwable
     */
    public function updateStatusReform(stdClass $reform)
    {

        $period = date("n", strtotime($reform->fec_apr));
        if (api_available()) {
            $this->apiFinancialService->updateStatusReformApi($reform);
        }
        $operation = Operation::where([
            ['company_code', '=', $reform->codemp],
            ['year', '=', $reform->anio],
            ['voucher_type', '=', $reform->sig_tip],
            ['number', '=', $reform->acu_tip],
        ])->first();

        if ($operation) {
            $operation->date_approval = $reform->fec_apr;
            $operation->status = $reform->estado;
            $operation->period = $period;
            $operation->voucher_type = $reform->sig_tip;
            $operation->number = $reform->acu_tip;
            $operation->save();
        } else {
            Operation::create(
                [
                    'company_code' => $reform->codemp,
                    'year' => $reform->anio,
                    'voucher_type' => $reform->sig_tip,
                    'number' => $reform->acu_tip,
                    'date_assignment' => $reform->fec_asi,
                    'date_approval' => $reform->fec_apr,
                    'status' => $reform->estado,
                    'period' => $period,
                    'total_debit' => $reform->tot_deb,
                    'total_credit' => $reform->tot_cre,
                    'description' => $reform->des_cab,
                    'date_created' => $reform->fec_cre,
                    'created_by' => $reform->cre_por
                ]
            );
        }


        $details = OperationDetail::where([
            ['company_code', '=', $reform->codemp],
            ['year', '=', $reform->anio],
            ['voucher_type', '=', $reform->sig_tip],
            ['number', '=', $reform->acu_tip],
        ])->get();

        foreach ($details as $detail) {
            $detail->status = $reform->estado;
            $detail->save();
        }
    }

    /**
     * Buscar periodo contable
     *
     * @param int $year
     * @param string $companyCode
     * @param int $period
     *
     * @return array
     */
    public function findAccountingPeriod(int $year, string $companyCode, int $period)
    {

        return api_available() ? $this->apiFinancialService->findAccountingPeriodApi($year, $period) : collect([]);
    }

    /**
     * Crea certificacion presupuestaria
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     * @param string $userCode
     *
     * @return array
     * @throws Throwable
     */
    public function createReformCertification(FiscalYear $fiscalYear, string $companyCode, string $userCode, Certification $certification)
    {
        $response = [];
        if (api_available()) {
            $response = $this->apiFinancialService->createReformCertificationApi($fiscalYear->year, $companyCode, $userCode, $certification);
        }
        return $response['reform'];
    }

    /**
     * Crear nuevos detalles de una certificacion
     *
     * @param Model $entity
     * @param array $reform
     * @param string $userCode
     * @throws Exception
     */
    private function insertDetailsCertification(Model $entity, array $reform, string $userCode)
    {
        if (api_available()) {
            $this->apiFinancialService->insertDetailsCertificationApi($entity, $reform, $userCode);
        }
    }
}
