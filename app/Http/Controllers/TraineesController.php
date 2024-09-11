<?php

namespace App\Http\Controllers;

use DB;
use DateTime;
use Exception;
use App\Models\Plan;
use App\Models\User;
use App\Models\Level;
use App\Models\Wallet;
use App\Models\Fitness;
use App\Models\Trainees;
use App\Models\Level_Body;
use App\Models\Competition;
use App\Models\Losing_Plan;
use App\Events\ProfileEvent;
use App\Models\Fitness_plan;
use App\Models\Level_Losing;
use App\Models\Losing_Width;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\Level_Fitness;
use Illuminate\Support\Carbon;
use App\Models\Building_Muscle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CatgptController;

class TraineesController extends Controller
{
    public function strtrainees(Request $request)
    {
        $validator = Validator::make($request->all(), [
           'gender'=>'required',
           'weight'=>'required',
           'age'=>'required',
           'tall'=>'required',
           'target'=>'required',
           'target_weight'=>'required',
           'days_number'=>'required'
           ]);
        if($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }


        $trainee = Trainees::create([
            'gender'=>$request->gender,
            'weight'=>$request->weight,
            'tall'=>$request->tall,
            'target'=>$request->target,
            'illness'=>$request->illness,
            'level'=>$request->level,
            'target_musle'=>$request->target_muscle,
            'target_weight'=>$request->target_weight,
            'days_number'=>$request->days_number,
            'has_sale'=>false,
            'age'=>$request->age,
            'user_id'=>Auth::id()
        ]);

        $compe = Competition::create([
            'score'=>0,
            'trainees_id'=>$trainee->id
        ]);


        $wallet = Wallet::create([
            'account'=>100000,
            'user_id'=>Auth::id()
        ]);

        // if($trainee) {

        //     event(new ProfileEvent($trainee));
        // }
        $num=0;
        $id=0;
        $muscle = $request->target_muscle;

        if($request->target == 'Build Musle') {

            if($request->level == 'advanced') {
                $id = '3';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 8;
                    $numg=4;  // تمارين عامة للعب مع تمارين العضلة الهدف
                } elseif ($request->illness == 'Knees Issues') {
                    $num = 15;
                    $numg=4;
                } else {
                    $num = 18;
                    $numg=4;
                }
            } elseif($request->level == 'middle') {
                $id='2';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 6;
                    $numg=3;
                } elseif ($request->illness == 'Knees Issues') {
                    $num = 10;
                    $numg=3;
                } else {
                    $num = 12;
                    $numg=3;
                }
            } else {
                $id='1';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 3;
                    $numg=2;
                } elseif ($request->illness == 'Knees Issues') {
                    $num = 7;
                    $numg=2;
                } else {
                    $num = 8;
                    $numg=2;
                }
            }





            if ($request->illness !== 'Knees Issues') {
                for($i = 0;$i<($request->days_number);$i++) {

                    $exe = Level_Body::where('target_muscle', $muscle)->where('level_id', $id)->inRandomOrder()->limit($num)->get();

                    foreach($exe as $r) {


                        $pl = Plan::create([

                           'buildmuscle_id'=>$r->buildmuscle_id,
                            'done'=>false,
                            'day'=>'day'.'_'.$i,
                            'trainees_id'=>$trainee->id,
                        ]);
                    }
                    $exeg = Level_Body::where('target_muscle', 'Body')->where('level_id', $id)->inRandomOrder()->limit($numg)->get();
                    foreach($exeg as $r) {


                        $p = Plan::create([

                           'buildmuscle_id'=>$r->buildmuscle_id,
                            'done'=>false,
                            'day'=>'day'.'_'.$i,
                            'trainees_id' =>  $trainee->id,
                        ]);

                    }
                }
            }


            // have  Knees problem

            elseif ($request->illness == 'Knees Issues') {
                for ($i = 0; $i < $request->days_number; $i++) {
                    $exe = Level_Body::where('target_muscle', $muscle)
                        ->where('level_id', $id)
                        ->inRandomOrder()
                        ->limit($num)
                        ->get();

                    foreach ($exe as $d) {
                        $a = Building_Muscle::where('id', $d->buildmuscle_id)->pluck('name');

                        $excludedExercises = ['astride jump', 'backwards jump', 'box jump down with leg', 'burpee', 'jack jump', 'jack burpee', 'jump squats', 'scissor jumps', 'starjump'];

                        if (!$a->contains(function ($value) use ($excludedExercises) {
                            return in_array($value, $excludedExercises);
                        })) {
                            $pl = Plan::create([
                                'buildmuscle_id' => $d->buildmuscle_id,
                                'done' => false,
                                'day' => 'day' . '_' . $i,
                                'trainees_id' => $trainee->id,
                            ]);
                        }
                    }

                    $exeg = Level_Body::where('target_muscle', 'Body')
                        ->where('level_id', $id)
                        ->inRandomOrder()
                        ->limit($numg)
                        ->get();

                    foreach ($exeg as $r) {
                        $p = Plan::create([
                            'buildmuscle_id' => $r->buildmuscle_id,
                            'done' => false,
                            'day' => 'day' . '_' . $i,
                            'trainees_id' => $trainee->id,
                        ]);
                    }
                }
            }


        } elseif($request->target == 'Get Toned') {

            if($request->level == 'advanced') {
                $id = '3 ';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 8;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 15;
                    $numg=4;
                } else {
                    $num = 18;

                }
            } elseif($request->level == 'middle') {
                $id='2';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 6;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 10;

                } else {
                    $num = 12;

                }
            } else {
                $id='1';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 3;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 5;

                } else {
                    $num = 8;

                }
            }

            if ($request->illness !== 'Knees Issues') {
                for($i = 0;$i<($request->days_number);$i++) {

                    $exe = Level_Fitness::where('level_id', $id)->inRandomOrder()->limit($num)->get();

                    foreach($exe as $r) {


                        $pl = Fitness_Plan::create([

                           'fitnesses_id'=>$r->fitness_id,
                            'done'=>false,
                            'day'=>'day'.'_'.$i,
                            'trainees_id'=> $trainee->id,
                        ]);
                    }

                }
            }
            // have  Knees problem

            elseif ($request->illness == 'Knees Issues') {
                for ($i = 0; $i < $request->days_number; $i++) {
                    $exe = Level_Fitness::where('level_id', $id)->inRandomOrder()->limit($num)->get();

                    foreach ($exe as $d) {
                        $a = Fitness::where('id', $d->fitness_id)->pluck('name');

                        $excludedExercises = ['astride jump', 'backwards jump', 'box jump down with leg', 'burpee', 'jack jump', 'jack burpee', 'jump squats', 'scissor jumps', 'starjump'];

                        if (!$a->contains(function ($value) use ($excludedExercises) {
                            return in_array($value, $excludedExercises);
                        })) {
                            $pl = Fitness_Plan::create([
                                'fitnesses_id' => $d->fitness_id,
                                'done' => false,
                                'day' => 'day' . '_' . $i,
                                'trainees_id' => $trainee->id,
                            ]);
                        }
                    }


                }
            }

        } else {
            if($request->level == 'advanced') {
                $id = '3 ';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 8;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 15;
                    $numg=4;
                } else {
                    $num = 18;

                }
            } elseif($request->level == 'middle') {
                $id='2';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 6;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 10;

                } else {
                    $num = 12;

                }
            } else {
                $id='1';
                if ($request->illness == 'Asthma' || $request->illness == 'Heart Diseases') {
                    $num = 3;

                } elseif ($request->illness == 'Knees Issues') {
                    $num = 5;

                } else {
                    $num = 8;

                }
            }

            if ($request->illness !== 'Knees Issues') {
                for($i = 0;$i<($request->days_number);$i++) {

                    $exe = Level_Losing::where('level_id', $id)->inRandomOrder()->limit($num)->get();

                    foreach($exe as $r) {


                        $pl = Losing_Plan::create([

                           'Losing_id'=>$r->Losing_id,
                            'done'=>false,
                            'day'=>'day'.'_'.$i,
                            'trainees_id'=>$trainee->id,
                        ]);
                    }

                }
            }
            // have  Knees problem

            elseif ($request->illness == 'Knees Issues') {
                for ($i = 0; $i < $request->days_number; $i++) {
                    $exe = Level_Losing::where('level_id', $id)->inRandomOrder()->limit($num)->get();

                    foreach ($exe as $d) {
                        $a = Losing_Width::where('id', $d->Losing_id)->pluck('name');

                        $excludedExercises = ['astride jump', 'backwards jump', 'box jump down with leg', 'burpee', 'jack jump', 'jack burpee', 'jump squats', 'scissor jumps', 'starjump'];

                        if (!$a->contains(function ($value) use ($excludedExercises) {
                            return in_array($value, $excludedExercises);
                        })) {
                            $pl = Losing_Plan::create([
                                'Losing_id' => $d->Losing_id,
                                'done' => false,
                                'day' => 'day' . '_' . $i,
                                'trainees_id' => $trainee->id,
                            ]);
                        }
                    }


                }
            }


        }



    }



    public function home()
    {
        $levels = array();
        $user = User::find(Auth::id());
        $request = $user->trainee;

        if($request->target == 'Build Musle') {


            $muscle = $request->target_musle;
            for($i = 0;$i<3;$i++) {

                $level = Level::find($i+1);
                $ex = $level->BuildingMuscle()->where('target_muscle', $muscle)->withPivot('set', 'repition', 'duration')->get();

                $levels['level'.($i+1)] = $ex;
            }

            return response()->json($levels, 200);


        } elseif($request->target == 'Get Toned') {
            for($i = 0;$i<3;$i++) {

                $level = Level::find($i+1);
                $ex = $level->fitness()->withPivot('set', 'repition', 'duration')->get();

                $levels['level'.($i+1)] = $ex;
            }

            return response()->json($levels, 200);

        } else {

            for($i = 0;$i<3;$i++) {

                $level = Level::find($i+1);
                $ex = $level->losingweight()->withPivot('set', 'repition', 'duration')->get();

                $levels['level'.($i+1)] = $ex;
            }

            return response()->json($levels, 200);

        }


    }


public function compareTimeHourMinute()
{
    $id = Auth::id();
    $notification = Notification::where('user_id', $id)->value('specific_time');

    if (!$notification) {
        return 'Notification not found.';
    }

    $databaseTime = Carbon::parse($notification);
    $currentTime = Carbon::now();

    if ($currentTime->lt($databaseTime)) {
        return 'Current time is before the database time.';
    } elseif ($currentTime->gt($databaseTime)) {
        return 'Current time is after the database time.';
    } else {
        return 'Current time is the same as the database time.';
    }
}
}





