<?php

namespace App\Repositories\Salary;

use LaravelEasyRepository\Repository;

interface SalaryRepository extends Repository
{
    public function getSalaryByUserID($user_id);
}
