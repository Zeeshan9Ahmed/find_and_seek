<?php

namespace App\Http\Controllers\Api\User\Job;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Job\CreateJobRequest;
use App\Http\Requests\Api\User\Job\DeleteJobRequest;
use App\Http\Requests\Api\User\Job\EditJobRequest;
use App\Http\Requests\Api\User\Job\SearchJobRequest;
use App\Http\Resources\JobResource;
use App\Models\Job;
use App\Models\RecentSearches;
use App\Services\Notifications\CreateDBNotification;
use App\Services\Notifications\PushNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class JobController extends Controller
{
    public function createJob(CreateJobRequest $request) 
    {
        $job = Job::create($request->validated()+['user_id' => auth()->id()]);
        $this->sendJobNotificationToUsers($job);
        return commonSuccessMessage("Job Created Successfully");
    }

    protected function sendJobNotificationToUsers($job)
    {
        $data = [
            'to_user_id'        =>  0,
            'from_user_id'      =>  auth()->id(),
            'notification_type' =>  'JOB_CREATE',
            'title'             =>  auth()->user()->full_name ." has created a new $job->title job" ,
            'redirection_id'    =>   $job->id,
            'description'       => 'JOB_CREATE DESCRIPTION',
            'full_name'         => auth()->user()->full_name,
        ];

        $tokens = DB::table('users')->where('role','user')->pluck('device_token')->toArray();
         app(CreateDBNotification::class)->execute($data);

        app(PushNotificationService::class)->execute($data,$tokens);

    }


    public function allJobs()
    {
        // return $this->getJobs();
        return apiSuccessMessage("All Jobs", JobResource::collection($this->getJobs()));
    }

    public function SearchJobOrCompany(SearchJobRequest $request)
    {
        $search = $request->key_word;
        $filtered_jobs = $this->getJobs( "", "", $search);
        // return $filtered_jobs;
        $this->addInRecentSearches($search, $filtered_jobs);
        return apiSuccessMessage("Filtered Jobs", JobResource::collection($filtered_jobs));
    }

    protected function addInRecentSearches($search, $data)
    {
        foreach($data as $key => $value)
        {
            $insert_data = [
                'searched_by' => auth()->id(),
                'searched_user_id' => $value->user_id,
                'searched_text' => $search,
                'job_id' => $value->id,
                'type' => 'user'
            ];
            if (!RecentSearches::where($insert_data)->exists()){
                RecentSearches::create($insert_data);
            }
        }
    }

    public function editJob(EditJobRequest $request)
    {
        $job = Job::find($request->job_id);

        if ( !$job )
        {
            return commonErrorMessage("No Job Found", 404);
        }

        if ( $job->user_id != auth()->id())
        {
            return commonErrorMessage("Can't Update", 400);
        }
        $job->update($request->validated());
        return apiSuccessMessage("Job Updated", new JobResource($this->getJobs("", $job->id)));
    }

    public function myJobs()
    {
        return apiSuccessMessage("My Jobs", JobResource::collection($this->getJobs(auth()->id())));
    }

    public function getJob($job_id)
    {
        $job = $this->getJobs('', $job_id);
        return $job?apiSuccessMessage("Job Detail", new JobResource($job)):commonErrorMessage("Not Found", 400);
        // return apiSuccessMessage("Job Detail", new JobResource($job));
    }

    
    public function deleteJob(DeleteJobRequest $request)
    {
        $job = Job::find($request->id);

        if ( !$job ) return commonErrorMessage("Not found", 404);
        
        $this->deleteNotificationsOfJob($job->id);
        $this->deleteRecievedPitchesOfJob($job->id);
        $job->delete();
        return commonSuccessMessage('Success');
    }

    protected function deletePitchesOfJob($job_id)
    {
        return DB::table('job_pitches')->where('job_id', $job_id)->delete();
    }
    protected function deleteNotificationsOfJob($job_id)
    {
        return DB::table('notifications')->where(['redirection_id' => $job_id, 'notification_type' => 'JOB_CREATE'])->delete();
    }
    protected function getJobs($user_id = '', $job_id = '', $search = '')
    {
        $filter = DB::table('filters')->where('user_id', auth()->id())->first();

        $data =  DB::table('jobs')
            ->join('users', 'jobs.user_id', 'users.id')
            ->leftjoin('companies', 'companies.user_id', 'users.id')
            ->select(
                'jobs.id',
                'title',
                'description',
                'job_type',
                'location',
                'from',
                'to',
                'salary_type',
                'other',
                'users.id as user_id',
                'companies.representative_name',
                'companies.representative_avatar',
                DB::raw('( SELECT IF(full_name IS NOT NULL, full_name, "") ) AS full_name'),
                DB::raw('( SELECT IF(avatar IS NOT NULL, avatar, "") )AS avatar'),
                DB::raw('( SELECT count(id) from job_pitches where (job_pitches.job_id = jobs.id AND job_pitches.user_id = '.auth()->id().')  )AS ptich_sent'),
                'role',
            );
            
            if ( $user_id )
            {
                $data = $data->where('jobs.user_id', $user_id);
            }

            if ( $job_id )
            {
               return $data->where('jobs.id', $job_id)->first();
            }
            
            if (!$user_id && !$job_id && $filter)
            {
                $filter_query = $this->makeFilter($filter);

                if ( preg_match("/[a-z]/i", $filter_query)){
                    
                    $data->whereRaw(" $filter_query");
                }
    
            }
            if ( $search )
            {
                $data->whereRaw('(
                     ( 
                    users.full_name LIKE "%'.$search.'%" 
                    OR 
                    jobs.title LIKE "%'.$search.'%" 
                    OR 
                    jobs.description LIKE "%'.$search.'%"
                    OR
                    jobs.from LIKE "%'.$search.'%" 
                    OR 
                    jobs.to LIKE "%'.$search.'%" 
                    OR 
                    jobs.other LIKE "%'.$search.'%"
                    )
                )');
                
            }
            
        return $data->where('users.deleted_at',Null)
        ->latest('jobs.created_at')
        // ->toSql();
            ->get();
    }

    protected function makeFilter($filter){
                $start_salary = $filter->start_salary;
                $end_salary = $filter->end_salary;
                
                $benefits =  $filter->benefits?explode(',',$filter->benefits):[];
                $query = "";
                $title = $filter->job_title?" title = '$filter->job_title'  " : "";
                $other_search = implode('' , array_map(function($benefit, $key)use($start_salary, $title){
                    $or = ' OR';
                    if ($start_salary == 0 && $key == 0 ){
                            $or = '';
                    }
                    if (($start_salary == 0 || $start_salary > 0) && $key == 0 && preg_match("/[a-z]/i", $title)){
                            $or = " AND ";
                    }
                    return "$or FIND_IN_SET('$benefit' , other) ";
                }, $benefits , array_keys($benefits)));
                $query .= "$title  ";
                if ($start_salary == $end_salary && $start_salary > 0  )
                {
                    $query .= " AND REPLACE(jobs.from ,',','') = $start_salary $other_search  ";
                }else {
                    $and_condition = $title?" AND ":"";
                    $from = $start_salary?" $and_condition REPLACE(jobs.from,',','') >= $start_salary":" ";
                    if (trim($from) || trim($title)){
                        $and_condition = " AND ";
                    }else{
                        $and_condition = "";
                    }
                    $to = $end_salary?" $and_condition REPLACE(jobs.to , ',','') <= $end_salary ":" ";
                    $query .=" $from  $to  $other_search ";
                }
        return $query;
    }
}
