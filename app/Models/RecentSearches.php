<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecentSearches extends Model
{
    use HasFactory;

    protected $fillable = [
        'searched_by' ,
        'searched_user_id' ,
        'searched_text' ,
        'job_id' ,
        'type' 
    ];
}
