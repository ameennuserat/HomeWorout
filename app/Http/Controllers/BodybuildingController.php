<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Level;
use App\Models\Building_Muscle;
class BodybuildingController extends Controller
{
    public function getex(){

        // $a = Level::with('bodybuild')->get();
        // return response()->json($a);


         $b = 'arm';
        // $level_id = 1;
        // $a = Bodybuilding::whereHas('levels', function ($query) use ($level_id){
        //     $query->where('level_id', $level_id);
        // })->pivot->set;
        // //->where('target_muscle',$b)->inRandomOrder()->limit(2)->get()
        // return response()->json($a);




        // $level_id = 1;
        //     //$role = 'author';
        //     $books = Level::find($level_id)->bodybuild()->get();
        //     return response()->json($books);
            $id = '2';
        $level = Level::find($id);
        $ex = $level->BuildingMuscle()->where('target_muscle',$b)->get();
        return response()->json($ex);
        //->where('target_muscle',$b)->inRandomOrder()->limit(2)
        // $Bodybuilding=Level::with('bodybuild')->get();
        // return response()->json($Bodybuilding);
    }
}
