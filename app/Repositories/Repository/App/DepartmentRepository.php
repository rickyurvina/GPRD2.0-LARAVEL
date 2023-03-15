<?php

namespace App\Repositories\Repository\App;

use App\Models\Admin\Department;
use App\Repositories\Library\Eloquent\Repository;
use App\Repositories\Library\Exceptions\RepositoryException;
use App\Repositories\Repository\Configuration\SettingRepository;
use App\Services\ApiFinancialService;
use Illuminate\Container\Container as App;
use Illuminate\Support\Collection;

/**
 * Clase DepartmentRepository
 *
 * @package App\Repositories\Repository\App
 */
class DepartmentRepository extends Repository
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
     * @param App $app
     * @param Collection|null $collection
     * @param SettingRepository $settingRepository
     *
     * @throws RepositoryException
     */
    public function __construct(App                 $app, Collection $collection, SettingRepository $settingRepository,
                                ApiFinancialService $apiFinancialService)
    {
        parent::__construct($app, $collection);
        $this->settingRepository = $settingRepository;
        $this->apiFinancialService = $apiFinancialService;
    }

    /**
     * Especificar el nombre de la clase del modelo.
     *
     * @return string
     */
    public function model(): string
    {
        return Department::class;
    }

    /**
     *  Cantidad de proyectos e inversión por Departamentos
     *
     * @param int $year
     * @param string $date
     *
     * @return \Illuminate\Http\Client\Response
     * @throws \Exception
     */
    public function totalsByYear(int $year)
    {
        return $this->apiFinancialService->totalsByYearApi($year);
    }

}
