<?php

namespace App\Repositories;

use App\Entities\Employee;
use App\Entities\Contract;
use App\Facades\Config;
use App\Factories\DataSourceFactory;
use App\Interfaces\RepositoryInterface;

class EmployeeRepository implements RepositoryInterface
{
    /**
     * @var string
     */
    private string $source;

    /**
     * @var string
     */
    protected string $entityName = 'employees';

    /**
     * @var DataSourceFactory
     */
    protected DataSourceFactory $dataSourceFactory;

    public function __construct()
    {
        $this->source = Config::get('app.data_source');
        $this->dataSourceFactory = new DataSourceFactory();
    }

    /**
     * @return array
     */
    public function getAll(): array
    {
        $inputSource = $this->dataSourceFactory->make($this->source);

        $data = $inputSource->entity($this->entityName)->fetch();

        return $this->hydrate($data);
    }

    /**
     * @param array $data
     * @return array
     */
    public function hydrate(array $data): array
    {
        $employees = [];

        foreach ($data as $employee) {
            $newEmployee = new Employee();

            foreach ($employee as $column => $value) {
                $newEmployee->$column = $value;
            }

            $newEmployee->setContract(new Contract());

            if ($newEmployee->hasSpecialContract()) {
                $newEmployee->getContract()->updateMaxVacationDays($newEmployee->special_contract_vacation_days);
            }

            $employees[] = $newEmployee;
        }

        return $employees;
    }
}