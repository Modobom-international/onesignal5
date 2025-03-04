<?php

namespace App\Repositories\Attendance;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Attendance;

class AttendanceRepositoryImplement extends Eloquent implements AttendanceRepository{

    /**
    * Model class to be used in this repository for the common methods inside Eloquent
    * Don't remove or change $this->model variable name
    * @property Model|mixed $model;
    */
    protected Attendance $model;

    public function __construct(Attendance $model)
    {
        $this->model = $model;
    }

    // Write something awesome :)
}
