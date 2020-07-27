<?php

namespace App\Http\Controllers;

use App\User;
use App\Activity;
use App\ActivityTags;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $activities = Activity::where('user_id', Auth::user()->id)->latest('updated_at')->with('tags')->simplePaginate(50);
        $users = User::get();

        if($activities->count() > 0) {
            if ($request->ajax()) {
                $activities = view('activity.index', compact('activities'))->render();
                return response()->json(['html'=>$activities]);
            }
    
            return view('activity.index', compact('activities', 'users'));
        }
        return redirect()->route('activity.create')->with('info', 'You need to add an Activity!');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('activity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateActivity($request);

        $activity = new Activity();
        $activity->from_address = $request->input('from_address');
        $activity->from_location = $request->input('from_location');
        $activity->from_latitude = $request->input('from_latitude');
        $activity->from_longitude = $request->input('from_longitude');

        $activity->to_address = $request->input('to_address');
        $activity->to_location = $request->input('to_location');
        $activity->to_latitude = $request->input('to_latitude');
        $activity->to_longitude = $request->input('to_longitude');

        $activity->start_date = $request->input('start_date');
        $activity->end_date = $request->input('end_date');
        $activity->user_id = Auth::user()->id;
        $activity->save();

        if ($request->has('tags')){
            // dd($request->has('tags');
            $tags = explode(",", $request->tags);
            foreach($tags as $person) {
                $user = User::where('name', 'LIKE', $person.'%')
                        ->orWhere('username', 'LIKE', $person.'%')
                        ->first();
                if ($user) {
                    $activityTag = new ActivityTags;
                    $activityTag->activity_id   = $activity->id;
                    $activityTag->person_id     = $user->id;
                    $activityTag->user_id       = Auth::user()->id;
                    $activityTag->save();
                } 
            }
        }

        // for users not on the platform
        if($request->has('name')){
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');

            foreach($name as $key => $value) {
                $user = User::where('email', $email[$key])->first();
                if ($user) {
                    $activityTag = new ActivityTags;
                    $activityTag->activity_id   = $activity->id;
                    $activityTag->person_id     = $user->id;
                    $activityTag->user_id       = Auth::user()->id;
                    $activityTag->save();
                } else {
                    $activityTag = new ActivityTags;
                    $activityTag->name          = $name[$key];
                    $activityTag->email         = $email[$key];
                    $activityTag->phone         = $phone[$key];
                    $activityTag->activity_id   = $activity->id;
                    $activityTag->user_id       = Auth::user()->id;
                    $activityTag->save();
                }
            }
        }

        return redirect()->route('activity.index')->with('success', 'Successful!');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function show(Activity $activity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activity $activity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activity  $activity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activity $activity)
    {
        //
    }

    public function validateActivity(Request $request){

		$rules = [
            'from_location' => 'required',
            'from_latitude' => 'required',
            'from_latitude' => 'required',
            'to_location' => 'required',
            'to_latitude' => 'required',
            'to_latitude' => 'required',
            'activity_tags.*.name' => 'sometimes',
            'activity_tags.*.email' => 'sometimes',
            'activity_tags.*.phone' => 'sometimes',
        ];

        $messages = [
            'from_latitude' => 'Select a valid location.',
        ];
         
		$this->validate($request, $rules, $messages);
    }
}