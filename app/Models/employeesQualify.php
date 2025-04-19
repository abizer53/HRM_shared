<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employeesQualify extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function employee()
    {
        return $this->hasOne('App\Models\employee', 'id', 'employee_id',);
    }
}
