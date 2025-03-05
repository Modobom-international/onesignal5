<?php

namespace App\Repositories\User;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\User;

class UserRepositoryImplement extends Eloquent implements UserRepository
{

    /**
     * Model class to be used in this repository for the common methods inside Eloquent
     * Don't remove or change $this->model variable name
     * @property Model|mixed $model;
     */
    protected User $model;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function getUserByNameOrEmail($keyword)
    {
        $query = $this->model->where('name', 'LIKE', "%$keyword%")
            ->orWhere('email', 'LIKE', "%$keyword%")
            ->latest()
            ->paginate();

        return $query;
    }

    public function getUsers()
    {
        $query = $this->model->latest()
            ->paginate();

        return $query;
    }
}
