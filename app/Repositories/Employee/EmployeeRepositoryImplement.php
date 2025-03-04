<?php

namespace App\Repositories\Employee;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Employee;

class EmployeeRepositoryImplement extends Eloquent implements EmployeeRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Employee $model;

    public function __construct(Employee $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
