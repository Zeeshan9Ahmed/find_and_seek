<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profession extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'company',
        'designation',
        'start_date',
        'end_date',
        'reason_of_leaving',

    ];
}
