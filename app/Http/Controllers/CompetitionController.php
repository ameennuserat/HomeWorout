<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Trainees;
use App\Models\Competition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompetitionController extends Controller
{
    public function addscore(Request $request)
    {
        $user = User::find(Auth::id());
        $trainee = $user->trainee;
        $comp = $trainee->competition;
        $comp->score = $comp->score + $request->score;
        $comp->save();
        return response()->json('successfully',200);
    }

    public function top3()
    {
        Competition::truncate();
        $wins = array();
        $i = 0;
        $top = Competition::orderBy('score', 'desc')->get();
        foreach($top as $r) {
            $Competition = Competition::find($r->id);
            $trainee = $Competition->trainee;
            if($i<3) {
                $trainee->has_sale =$trainee->has_sale+1 ;
                $trainee->save();
            }
            $user = $trainee->user;
            $train = $user->name.' '.$r->score;
            $win[$i]=$train;
            $i++;
        }
        return response()->json($wins, 200);
    }
}
