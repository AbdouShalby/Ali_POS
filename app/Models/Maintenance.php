<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'phone_number',
        'device_type',
        'problem_description',
        'cost',
        'password',
        'status',
    ];
}
