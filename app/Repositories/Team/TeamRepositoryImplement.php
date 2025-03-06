<?php

namespace App\Repositories\Team;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\Team;

class TeamRepositoryImplement extends Eloquent implements TeamRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected Team $model;

    public function __construct(Team $model)
    {
        $this->model = $model;
    }

    public function getTeams()
    {
        $query = $this->model->with('permissions')->get();

        return $query;
    }

    public function findTeam($id)
    {
        $query = $this->model->with('permissions')->where('id', $id)->first();

        return $query;
    }
}
