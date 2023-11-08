<?php

namespace App\Http\Controllers\Api\User\Home;

use App\Http\Controllers\Controller;
use App\Http\Requests\analyticsDataRequest;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function homeData()
    {
        $jobs_count = DB::table('jobs')
            ->where('jobs.user_id', auth()->id())
            ->select(
                DB::raw('"job_count" as `key`'),
                DB::raw('COUNT(*) as `value`'),
            );
        $job_ids = Job::where('user_id', auth()->id())->pluck('id');
        
        $applications_count = DB::table('job_pitches')
            ->whereIn('job_id', $job_ids)
            ->select(
                DB::raw('"applications_count" as `key`'),
                DB::raw('COUNT(*) as `value`'),
            );
            
        $count = $jobs_count
                    ->unionAll($applications_count)
                    ->get()
                    ->mapWithKeys( function ($item , $key) {
                        return [$item->key => $item->value];
                    } )
                    ->toArray();
        return apiSuccessMessage("Dashborad Data", $count);
    }

    public function analytics()
    {
        $profile_views_count = DB::table('profile_views')
        ->where('user_id', auth()->id())
        ->join('users', 'users.id', 'profile_views.seen_by')
        ->where('users.deleted_at', NULL)
        ->select(
            DB::raw('"profile_views_count" as `key`'),
            DB::raw('COUNT(users.id) as `value`'),
        );
        $search_appearance_count = DB::table('recent_searches')
        ->where('searched_user_id', auth()->id())
        ->join('users', 'users.id', 'recent_searches.searched_by')
        ->where('users.deleted_at', NULL)
        ->when(auth()->user()->role == 'user', function($query){
           $query->where('type', 'company');
        })
        ->when(auth()->user()->role != 'user', function($query){
            $query->where('type', 'user');
        })
        ->select(
            DB::raw('"search_appearance_count" as `key`'),
            DB::raw('COUNT(users.id) as `value`'),
        );
        // return $search_appearance_count->get();
        //search_appearance_count

        $count = $profile_views_count
                    ->unionAll($search_appearance_count)
                    ->get()
                    ->mapWithKeys( function ($item , $key) {
                        return [$item->key => $item->value];
                    } )
                    ->toArray();
        // return $profile_views_count;
        return apiSuccessMessage("Analytics", $count);
    }

    public function analyticsData(analyticsDataRequest $request) 
    {
        if ( $request->type == 'profile')
            return apiSuccessMessage("Profile Views", $this->getProfiles());
    }

    protected function getProfiles()
    {
        return collect(DB::select('select id, full_name, avatar from users where id in ( select seen_by from profile_views where user_id = "'.auth()->id().'") AND users.deleted_at IS NULL'));
    }
}
