<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = ['name', 'guard_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function getDescriptionForEvent($eventName)
    {
        return __CLASS__ . " model has been {$eventName}";
    }
}
