<?php

namespace App\Repositories\Repository\SFGPROV;

use App\Models\Business\Planning\FiscalYear;
use App\Models\Business\Tracking\Operation;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Clase SFGPROVRepository
 * @package App\Repositories\Repository\SFGPROV
 */
class ProformaRepository
{

    protected $apiFinancialService;

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
     * Obtener el año fiscal de la BD de SFGPROV.
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return mixed
     * @throws \Exception
     */
    public function getFiscalYear(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->getFiscalYearApi($fiscalYear->year) : collect([]);
    }

    /**
     * Verificar si una proforma ya existe en el sistema SFGPROV.
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return mixed
     * @throws \Exception
     */
    public function proformaExists(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->proformaExistsApi($fiscalYear->year) : collect([]);
    }

    /**
     * Sincronizar la proforma (almacenar en la BD de SFGPROV).
     *
     * @param Collection $proformas
     * @param Operation $operation
     * @param Collection $operationDetails
     *
     * @throws Throwable
     */
    public function syncProforma(Collection $proformas, Operation $operation, Collection $operationDetails)
    {
        if (api_available()) {
            $this->apiFinancialService->syncProformaApi($proformas, $operation, $operationDetails);
        }
    }

    /**
     * Obtiene los ingresos con sus valores codificados
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getCodifiedIncomes(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->getCodifiedIncomesApi($fiscalYear->year) : collect([]);
    }

    /**
     * Obtiene los gastos con sus valores codificados
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getCodifiedExpenses(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->getCodifiedExpensesApi($fiscalYear->year) : collect([]);
    }

    /**
     * Obtiene los ingresos almacenados en la proforma
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getProformaIncomes(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->getProformaIncomesApi($fiscalYear->year) : collect([]);
    }

    /**
     * Obtiene los gastos almacenados en la proforma
     *
     * @param FiscalYear $fiscalYear
     * @param string $companyCode
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getProformaExpenses(FiscalYear $fiscalYear, string $companyCode)
    {
        return api_available() ? $this->apiFinancialService->getProformaExpensesApi($fiscalYear->year) : collect([]);
    }

    /**
     * Ingresa una nueva estructura de ingresos o partidas presupuestarias en el sistema financiero
     *
     * @param Collection $structure
     * @param string|null $currentCode
     * @param int|null $year
     *
     * @throws Throwable
     */
    public function syncStructure(Collection $structure, string $currentCode = null, int $year = null)
    {
        if (api_available()) {
            $this->apiFinancialService->syncStructureApi($structure, $currentCode, $year);
        }
    }

    /**
     * Elimina un registro de ingreso de la tabla prplacta
     *
     * @param string $code
     * @param int $year
     * @throws \Exception
     */
    public function destroy(string $code, int $year)
    {
        if (api_available()) {
            $this->apiFinancialService->destroyProformaRepositoryApi($year, $code);
        }
    }
}
