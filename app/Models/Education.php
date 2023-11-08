<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'level_of_education',
        'degree',
        'major',
        'passing_year',
        'percentage',
        'school_name'
    ];
}
