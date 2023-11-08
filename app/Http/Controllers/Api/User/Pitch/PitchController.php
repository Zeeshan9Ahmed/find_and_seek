<?php

namespace App\Http\Controllers\Api\User\Pitch;

use App\Events\SendNotificationToRecruiterEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\Pitch\DeletePitchRequest;
use App\Http\Requests\Api\User\Pitch\GetPitchRequest;
use App\Http\Requests\Api\User\Pitch\SendPitchRequest;
use App\Http\Requests\Api\User\Pitch\UploadPitchRequest;
use App\Http\Resources\ReceivedPitchesResource;
use App\Models\Job;
use App\Models\JobPitch;
use App\Models\Pitch;
use App\Models\RecentSearches;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class PitchController extends Controller
{
    public function getPitches(GetPitchRequest $request)
    {
        $pitches = DB::table('pitches')
                        ->select(
                            'id',
                            'pitch_url',
                            'type',
                            'thumbnail'
                        )
                        ->where('model_id', $request->user_id )->latest()->get();
                        
                        $response = [
                            'status' => 1, 
                            'message' => 'Pitches List', 
                            "data" =>   collect($pitches->filter(function($pitch){
                                return $pitch->type == null;
                            }))->values(), 
                            'rep_pitches' =>  ($pitches->filter(function($pitch){
                                return $pitch->type != null;
                            }))->values()];

        return $response;
        return apiSuccessMessage("Pitches List", $pitches);
    }

    
    public function exceptionalPitches()
    {
        
        $exceptional_pitches =  DB::table('pitches')
                ->select(
                    'id',
                    'pitch_url',
                    'thumbnail'
                )
                ->where('model_type', '')
                ->get();
        return apiSuccessMessage("Exceptional Pitches", $exceptional_pitches);
    }
    
    public function getMyPitches()
    {
        // return;
        $my_pitches = DB::table('job_pitches')
                        ->join('jobs','jobs.id', 'job_pitches.job_id')
                        ->join('users','users.id', 'jobs.user_id')
                        ->leftjoin('companies','companies.user_id', 'users.id')
                        ->where('users.deleted_at', Null)
                        ->select(
                            'job_pitches.id',
                            'jobs.id as job_id',
                            'users.id as company_id',
                            'job_pitches.pitch_url',
                            'job_pitches.thumbnail as thumbnail',
                            'companies.representative_name',
                            'companies.representative_avatar',
                            DB::raw('( SELECT IF(users.full_name IS NOT NULL, users.full_name, "") ) AS full_name'),
                            DB::raw('( SELECT IF(users.avatar IS NOT NULL, users.avatar, "") )AS avatar'),
                            'jobs.title as job_title'
                        )
                        ->where('job_pitches.user_id', auth()->id())
                        ->get();
        return apiSuccessMessage("My Pitches", $my_pitches);
    }

    public function deletePitch(DeletePitchRequest $request)
    {
        $pitch = DB::table('pitches')->where('id',$request->pitch_id); 
        // return $pitch->pluck('pitch_url')->first();
        if ($pitch->first()->model_id != auth()->id())
        {
            return commonErrorMessage("Can Not Delete", 400);
        }
        removeFile( $pitch->pluck('pitch_url')->first() );

        $pitch->delete();
        return commonSuccessMessage("Pitch Deleted");
    }

    public function getReceivedPitches()
    {
        $received_pitches = DB::select('select job_pitches.id,jobs.id as job_id , job_pitches.thumbnail as thumbnail ,job_pitches.pitch_url,users.id as user_id ,   
                                        IF(users.avatar IS NOT NULL, users.avatar, "") as avatar ,full_name, 
                                        jobs.title as job_title from job_pitches 
                                        JOIN 
                                        users on users.id = job_pitches.user_id And users.deleted_at IS NULL 
                                        JOIN 
                                        jobs on jobs.id = job_pitches.job_id 
                                        WHERE  
                                        job_pitches.job_id in 
                                        ( select id  from jobs where user_id = '.auth()->id().'  ) 
                                        AND 
                                        job_pitches.created_at BETWEEN NOW() - INTERVAL 30 DAY AND NOW()

                                        order by id desc');
        
        // return apiSuccessMessage("Recieved Pitches", collect($received_pitches));
        return apiSuccessMessage("Recieved Pitches", ReceivedPitchesResource::collection($received_pitches));
    }

    public function uploadPitch(UploadPitchRequest $request)
    {
        
        if( $request->hasFile('rep_pitch')){
            $this->removeLastPitchIfCountGreaterThanThree('rep_pitch');
            
            $uuid = Str::uuid();
            
            // $file_thumb_ = makeThumbnail($request->file('rep_pitch'));
            $file_thumb_ = "";
            $imageName = $uuid. time().'.'.$request->rep_pitch->getClientOriginalExtension();
            $request->rep_pitch->move(public_path('/uploadedpitches'), $imageName);
            $pitch_url = asset('public/uploadedpitches')."/".$imageName;
            
                $data = new Pitch([
                    'pitch_url' => $pitch_url,
                    'type' => 'rep_pitch',
                    'thumbnail' => $file_thumb_,
                ]);
                auth()->user()->model()->save($data);
        }

        if($request->hasFile('pitch'))
        {

            $this->removeLastPitchIfCountGreaterThanThree();
            $uuid = Str::uuid();

            // $file_thumb_ = makeThumbnail($request->file('pitch'));
            $file_thumb_ = "";
            $imageName = $uuid. time().'.'.$request->pitch->getClientOriginalExtension();
            $request->pitch->move(public_path('/uploadedpitches'), $imageName);
            $pitch_url = asset('public/uploadedpitches')."/".$imageName;
            
                $data = new Pitch([
                    'pitch_url' => $pitch_url,
                    'thumbnail' => $file_thumb_,
                ]);
                auth()->user()->model()->save($data);
        }
        return commonSuccessMessage("Pitch Uploaded");
    }

    protected function removeLastPitchIfCountGreaterThanThree($type = Null)
    {
        $pitches = DB::table('pitches')->where('model_id', auth()->id())->where('type',$type);
        if ( $pitches->count() >= 3 )
        {
            $desc = $pitches->orderBy('id', 'asc');
            removeFile( $desc->pluck('pitch_url')->first() );
            $desc->limit(1)->delete();
        }
        return true;
    }

    public function searchPitch(Request $request) 
    {
        $keyword = $request->keyword;
        $searches = collect(DB::select('select job_pitches.id, jobs.id as job_id ,job_pitches.pitch_url, job_pitches.thumbnail as thumbnail ,users.id as user_id ,   
                                        IF(users.avatar IS NOT NULL, users.avatar, "") as avatar ,full_name, 
                                        jobs.title as job_title from job_pitches 
                                        join users on users.id = job_pitches.user_id And users.deleted_at IS NULL join 
                                        jobs on jobs.id = job_pitches.job_id 
                                        where ( jobs.title  LIKE "%'.$keyword.'%"  OR full_name LIKE "%'.$keyword.'%" ) 
                                        AND job_pitches.job_id in ( select id  from jobs where user_id = '.auth()->id().'  )
                                        order by id desc'));
        $this->addInRecentSearches($keyword, $searches);
        return apiSuccessMessage("Pitches Search", $searches);
    }

    protected function addInRecentSearches($search, $data)
    {
        foreach($data as $key => $value)
        {
            $insert_data = [
                'searched_by' => auth()->id(),
                'searched_user_id' => $value->user_id,
                'searched_text' => $search,
                'job_id' => $value->job_id,
                'type' => 'company'
            ];
            if (!RecentSearches::where($insert_data)->exists()){
                RecentSearches::create($insert_data);
            }
        }
    }
    public function sendPitch(SendPitchRequest $request) 
    {
        
        if ( $this->hasSentPitchforJob($request->job_id)->count )
            return commonErrorMessage("Can not send",400);
        
        $url = '';
        $file_thumb_ = "";
        if ($request->pitch_type == 'url')
        {
            $url = $request->url;
            $file_thumb_ = $request->thumbnail;
        }else{

            if($request->hasFile('pitch'))
            {
                
                // $file_thumb_ = makeThumbnail($request->file('pitch'));
                $file_thumb_  = "";
                $imageName = time().'.'.$request->pitch->getClientOriginalExtension();
                $request->pitch->move(public_path('/uploadedpitches'), $imageName);
                $url = asset('public/uploadedpitches')."/".$imageName;
            }
        }

        JobPitch::create(
            [
                'job_id' => $request->job_id,
                'pitch_url' => $url,
                'user_id' => auth()->id(),
                'thumbnail' => $file_thumb_
            ]
        );
         $this->sendNotification($request->job_id);
        
        return commonSuccessMessage("Success");
    }

    protected function sendNotification($job_id)
    {
        $notification_data = collect(DB::table('jobs')
        ->select(
            'jobs.id as job_id',
            'jobs.title',
            'users.id as user_id',
            'users.device_token',
            DB::raw('( select "'.auth()->id().'"  )as sender_id'),
            DB::raw('( select "'.auth()->user()->full_name.'"  )as sender_name')
        )
        ->join('users', 'users.id', 'jobs.user_id')
        ->where('jobs.id', $job_id)->first());
        return $notification_data;
        event( new SendNotificationToRecruiterEvent($notification_data));
        
    }
    protected function hasSentPitchforJob($job_id)
    {
        return collect(DB::select('select count(id) as count from job_pitches where user_id = '.auth()->id().' AND job_id = '.$job_id.''))->first();
    }
}
