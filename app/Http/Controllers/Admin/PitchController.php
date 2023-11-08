<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pitch;
use Illuminate\Http\Request;
use Validator;

class PitchController extends Controller
{
    public function index()
    {
        $pitches = Pitch::orderBy('id', 'DESC')->get();
        return view('admin.pitches.index', ['pitches' => $pitches]);
    }

    public function create()
    {
        return view('admin.pitches.create');
    }

    public function store(Request $request)
    {
        $controls = $request->all();
        $rules = array(
            "url" => "required",
        );
        $validator = Validator::make($controls, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // if(!empty($request->file('image'))){
        //     $path = $request->file('image')->store('public/location');
        //           $file_path = Storage::url($path);
        //           // $submition_data['user_image'] = $file_path;
        //           $camera->cl_image = $file_path;
        //       }

        if ($request->hasFile('url')) {

            for ($i = 0; $i < count($request->url); $i++) {

                $pitch = new Pitch;
                $pitch->model_type = "";
                $pitch->model_id = 0;
                $pitch->thumbnail = makeThumbnail($request->file('url')[$i]);
                $imageName = time() . '.' . $request->url[$i]->getClientOriginalExtension();
                $request->url[$i]->move(public_path('/uploadedpitches/'), $imageName);
                $pitch->pitch_url = asset('public/uploadedpitches') . "/" . $imageName;

                $pitch->save();
            }

        }

        return redirect()->route('pitches')->withSuccess('Pitch Added Successfully...!');
    }

    public function edit($id)
    {
        $pitch = Pitch::find($id);
        return view('admin.pitches.edit', ['pitch' => $pitch]);
    }

    public function update(Request $request)
    {
        $controls = $request->all();
        $rules = array(
            "pitch_id" => "required",
            "url" => "nullable",
        );
        $validator = Validator::make($controls, $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pitch = Pitch::find($request->pitch_id);

        if ($request->hasFile('url')) {

            $ex = explode("findnseek/", $pitch->pitch_url);
            unlink($ex[1]);
			$thumb = explode('findnseek/', $pitch->thumbnail);
			unlink($thumb[1]);
            $pitch->thumbnail = makeThumbnail($request->file('url'));

            $imageName = time() . '.' . $request->url->getClientOriginalExtension();
            $request->url->move(public_path('/uploadedpitches/'), $imageName);
            $pitch->pitch_url = asset('public/uploadedpitches') . "/" . $imageName;
        }

        $pitch->save();

        return redirect()->route('pitches')->withSuccess('Pitch Added Successfully...!');
    }

    public function destroy(Request $request)
    {
        Pitch::destroy($request->id);
    }

}
