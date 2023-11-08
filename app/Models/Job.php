<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'job_type',
        'location',
        'salary_type',
        'from',
        'to',
        'other',
        'user_id',
    ];
}
