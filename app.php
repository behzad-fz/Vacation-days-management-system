<?php

use App\Repositories\EmployeeRepository;
use App\Validators\InputYearValidator;
use App\Services\VacationCalculator;
use App\Validators\OutputValidator;
use App\Factories\OutputFactory;

try {
    // Get given year from console
    $validator = new InputYearValidator($argv[1] ?? null);
    $inputYear = $validator->validate();

    // Calculate vacation days
    $calculator = new VacationCalculator($inputYear);
    $employeeRepository = new EmployeeRepository();
    $result = $calculator->calculateMultipleEmployees($employeeRepository->getAll());

    // Output the data
    $validator = new OutputValidator($argv[2] ?? null);
    $outputSource = $validator->validate();
    $format = $outputSource[0];
    $destination = $outputSource[1] ?? null;

    $outputMethod = (new OutputFactory())->make($format, $destination);
    $outputMethod->print($result);

} catch (Exception $e) {
    echo $e->getMessage();
    echo "\n";
    die();
}
