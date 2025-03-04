<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'users_id';
    protected $fillable = [
        'users_id',
        'position',
        'joining_date'
    ];
}
