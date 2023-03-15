<?php

namespace App\Repositories\Repository\App;

use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;

/**
 * Clase BudgetIndicatorRepository
 *
 * @package App\Repositories\Repository\App
 */
class BudgetIndicatorRepository
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
     *  Presupuesto por categoría
     *
     * @param int $year
     * @param string $date
     * @param array $codes
     * @param int $from
     * @param int $level
     * @param int $type
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function getIndicatorBudget(int $year, string $date, array $codes = [], int $from = 22, int $level = 9, int $type = 1): \Illuminate\Http\Client\Response
    {
        $this->sfgprov = json_decode($this->settingRepository->findByKey('gad'))->value->sfgprov;
        $param = [$this->sfgprov->company_code, $year, $date, $type, $level];
        return $this->apiFinancialService->getIndicatorBudgetApi($param, $codes, $from);
    }

}
