<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pitch extends Model
{
    use HasFactory;
    protected $fillable = [
        'pitch_url',
        'type',
        'thumbnail'
    ];
    public function model()
    {
        return $this->morphTo('model');
    }
}
