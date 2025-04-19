<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarryOver extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'employee_id',
        'leave_type_id',
        'expiry_date',
        'total',
        'grant_limit',
        'taken',
        'remaining',
        'expire_flag'
    ];
}
