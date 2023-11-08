<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;
use Hash;
use App\Models\User;
use App\Models\Admin;
use App\Models\Content;
use App\Models\Admin_content;
use DB;
use Carbon\Carbon;
use App\Mail\SendEmail;


Class ContentController extends Controller
{
	public function contents()
	{
		$content = Content::orderBy('id','DESC')->get();
		return view('admin.content.index',['contents' => $content]);
	}

	public function edit_content($id)
    {
           $contents = Content::find($id);
           return view('admin.content.update-content',['content' => $contents]);
    }

    public function update_content(Request $request)
    {
           $controls=$request->all();
           $rules=array(
                "description"=>"required",
                "id"=>"required",
           );
           $validator=Validator::make($controls,$rules);
           if ($validator->fails()) {
                  return redirect()->back()->withErrors($validator)->withInput();
           }

           $content=Content::find($request->id);
           $content->content = $request->description;
           $content->save();
           return redirect()->route('contents')->withSuccess('Content Added Successfully...!');
           // return redirect()->back()->withSuccess('Content Added Successfully...!');

    }


	public function destroy(Request $request)
	{
		Admin_content::destroy($request->id);
	}
}
