<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'avatar',
        'profile_completed',
        'device_type',
        'device_token',
        'password',
        'email_verified_at',
        'address',
        'contact',
        'city',
        'zip_code',
        'current_role',
        'role'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function model()
    {
        return $this->morphMany(Pitch::class,'model');
    }

    public function pitches() 
    {
        return $this->hasMany(Pitch::class,'model_id')->where('type',Null);
    }

    public function rep_pitches() 
    {
        return $this->hasMany(Pitch::class,'model_id')->where('type','rep_pitch');
    }
    public function professions() 
    {
        return $this->hasMany(Profession::class,'user_id');
    }

    public static function logged_in_user($id)
    {
        return  User::with('pitches','rep_pitches','professions')
                        ->leftjoin('companies',  'users.id', 'companies.user_id')
                        ->select(
                            'users.id',
                            'users.full_name',
                            'users.email',
                            'users.avatar',
                            'users.contact',
                            'users.current_role',
                            'users.address',
                            'users.city',
                            'users.state',
                            'users.role',
                            'users.job_title',
                            'users.is_social',
                            'profile_completed',
                            'device_type',
                            'device_token',
                            'email_verified_at',
                            'role',
                            'user_resume',
                            'resume_title',
                            'resume_description',
                            'zip_code',
                            'ideal_roles',
                            'representative_avatar',
                            'representative_name',
                            'representative_email',
                            'representative_contact',
                            'representative_address',
                            'representative_city',
                            'representative_state',
                            'representative_zip_code',
                            'company_employess',
                        )
                        ->where('users.id', $id)->first();
    }

    public function company()
    {
        return $this->hasOne(Company::class,'user_id');
    }
}
