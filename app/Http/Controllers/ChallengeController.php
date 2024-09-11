<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Fitness;
use App\Models\challenge;
use App\Models\Losing_Width;
use Illuminate\Http\Request;
use App\Models\Building_Muscle;
use Illuminate\Support\Facades\Auth;

class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function isadmin()
    {
        $user = USER::find(Auth::id());
        if($user->type == 'admin') {
            return response()->json('true', 200);
        } else {
            return response()->json('false', 200);
        }
    }

    public function viewbuildingexercise()
    {
        $exe = Building_Muscle::all();
        return response()->json($exe, 200);
    }


    public function viewlosingexercise()
    {
        $exe = Losing_Width::all();
        return response()->json($exe, 200);
    }


    public function viewfitnessexercise()
    {
        $exe = Fitness::all();
        return response()->json($exe, 200);
    }

    public function addchallenge(Request $request)
    {
        $request->validate([
            'day' => 'required|string',
            'name' => 'required|string',
            'detail' => 'required|string',
            'url_gif' => 'required|string',
        ]);

        $a = Challenge::create([
            'name'=>$request->name,
            'day'=>$request->day,
            'detail'=>$request->detail,
            'url_gif'=>$request->url_gif,
            'set'=>$request->set,
            'repition'=>$request->repition,
            'duration'=>$request->duration
        ]);
        return response()->json('successfully', 200);
    }

    public function deletechallenge($id)
    {
        $callenge = Challenge::find($id)->delete();
        return response()->json('successfully', 200);
    }

    public function deleteday($day)
    {
        $callenge = Challenge::where('day', $day)->delete();
        return response()->json('successfully', 200);
    }

    public function viewday($day)
    {
        $callenge = Challenge::where('day', $day)->get();
        return response()->json($callenge, 200);
    }


}
