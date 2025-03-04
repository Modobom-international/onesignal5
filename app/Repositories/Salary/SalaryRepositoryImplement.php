<?php

namespace App\Repositories\Salary;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Salary;

class SalaryRepositoryImplement extends Eloquent implements SalaryRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Salary $model;

    public function __construct(Salary $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
