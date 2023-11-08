<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title' ,
        'start_salary',
        'end_salary',
        'end_salary',
        'benefits',
    ];
}
