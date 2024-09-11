<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\Level;
use App\Models\result;
use App\Models\Fitness;
use App\Models\Warm_up;
use App\Models\Trainees;
use App\Models\Level_Body;
use App\Models\Losing_Plan;
use App\Models\Fitness_plan;
use App\Models\Level_Losing;
use App\Models\Losing_Width;
use Illuminate\Http\Request;
use App\Models\Level_Fitness;
use App\Models\Building_Muscle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CreatePlanController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function displayplan()
    {
        $id = Auth::id();
        $idt = Trainees::where('user_id', $id)->value('id');
        $days_number = Trainees::where('user_id', $id)->value('days_number');
        $level = Trainees::where('user_id', $id)->value('level');
        if($level == 'advanced') {
            $lev = 3;
        } elseif ($level == 'middle') {
            $lev = 2;
        } else {
            $lev = 1;
        }


        $target = Trainees::where('user_id', $id)->value('target');
        $f = [];
        $a=[];
        $wa=Warm_up::where('type', 'warm')->inRandomOrder()->limit(3)->get();
        $en=Warm_up::where('type', 'end')->inRandomOrder()->limit(2)->get();

        if($target == 'Get Toned') {
            for ($i = 0; $i < $days_number; $i++) {
                $e = Fitness_Plan::where('day', 'day_' . $i)->where('trainees_id', $idt)->pluck('fitnesses_id');
                $ex = Fitness::whereIn('id', $e)->get();
                $exercises = [];

                foreach ($ex as $item) {
                    $fitnessId = $item->id;

                    $duration = Level_Fitness::where('fitness_id', $fitnessId)->where('level_id', $lev)->value('duration');
                    $set = Level_Fitness::where('fitness_id', $fitnessId)->where('level_id', $lev)->value('set');
                    $repetition = Level_Fitness::where('fitness_id', $fitnessId)->where('level_id', $lev)->value('repition');



                    $exerciseDetails = [
                        'id'=> $item->id,
                        'name' => $item->name,
                        'url' => $item->url_gif,
                        'detail' => $item->detail,
                        'duration'=>$duration,
                        'sets'=>$set,
                        'repetition'=>$repetition,
                    ];

                    $exercises[] = $exerciseDetails;
                }

                $f["day$i"] = $exercises;
                $a["day$i"]=[$exercises,$wa,$en];
            }
        } elseif ($target =='Build Musle') {
            for ($i = 0; $i < $days_number; $i++) {
                $e = Plan::where('day', 'day_' . $i)->where('trainees_id', $idt)->pluck('buildmuscle_id');
                $ex = Building_Muscle::whereIn('id', $e)->get();
                $exercises = [];

                foreach ($ex as $item) {
                    $buildId = $item->id;

                    $duration = Level_Body::where('buildmuscle_id', $buildId)->where('level_id', $lev)->value('duration');
                    $set = Level_Body::where('buildmuscle_id', $buildId)->where('level_id', $lev)->value('set');
                    $repetition = Level_Body::where('buildmuscle_id', $buildId)->where('level_id', $lev)->value('repition');



                    $exerciseDetails = [
                        'id'=> $item->id,
                        'name' => $item->name,
                        'url' => $item->url_gif,
                        'detail' => $item->detail,
                        'duration'=>$duration,
                        'sets'=>$set,
                        'repetition'=>$repetition,
                    ];

                    $exercises[] = $exerciseDetails;
                }

                $f["day$i"] = $exercises;
                $a["day$i"]=[$exercises,$wa,$en];


            }
        } else {
            for ($i = 0; $i < $days_number; $i++) {
                $e = Losing_Plan::where('day', 'day_' . $i)->where('trainees_id', $idt)->pluck('Losing_id');
                $ex = Losing_Width::whereIn('id', $e)->get();
                $exercises = [];

                foreach ($ex as $item) {
                    $losingId = $item->id;

                    $duration = Level_Losing::where('Losing_id', $losingId)->where('level_id', $lev)->value('duration');
                    $set = Level_Losing::where('Losing_id', $losingId)->where('level_id', $lev)->value('set');
                    $repetition = Level_Losing::where('Losing_id', $losingId)->where('level_id', $lev)->value('repition');



                    $exerciseDetails = [
                        'id'=> $item->id,
                        'name' => $item->name,
                        'url' => $item->url_gif,
                        'detail' => $item->detail,
                        'duration'=>$duration,
                        'sets'=>$set,
                        'repetition'=>$repetition,
                    ];

                    $exercises[] = $exerciseDetails;
                }

                $f["day$i"] = $exercises;
                $a["day$i"]=[$exercises,$wa,$en];
            }

        }
        return $a;
    }




    // ت(اذا اختار اليوزر تعدبل الخطة بس رح يبقى عالهدف والليفل يلي اختارو اول شي  )
    public function showallextoadd()
    {
        $id=Auth::id();
        $target=Trainees::where('user_id', $id)->value('target');
        $level=Trainees::where('user_id', $id)->value('level');
        if ($level == 'advanced') {
            $level = '3';
        } elseif ($level == 'middle') {
            $level = '2';
        } else {
            $level = '1';
        }

        $f = [];

        if ($target == 'Get Toned') {


            $Eid = Level_Fitness::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $fitnessId = $item->fitness_id;
                $fitness = Fitness::where('id', $fitnessId)->first();

                if ($fitness) {
                    $exerciseDetails = [
                          'id'=>$fitness->id,
                            'name' => $fitness->name,
                            'url' => $fitness->url_gif,
                            'detail' => $fitness->detail,
                            'duration' => $item->duration,
                            'sets' => $item->set,
                            'repetition' => $item->repition,
                        ];

                    $f[] = $exerciseDetails;
                }
            }
        } elseif ($target == 'Losing Weight') {
            $Eid = Level_Losing::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $losingId = $item->Losing_id;

                $Losing_Width = Losing_Width::where('id', $losingId)->first();

                if ($Losing_Width) {
                    $exerciseDetails = [
                        'id'=>$Losing_Width ->id,
                        'name' => $Losing_Width ->name,
                        'url' => $Losing_Width ->url_gif,
                        'detail' => $Losing_Width ->detail,
                        'duration' => $item->duration,
                        'sets' => $item->set,
                        'repetition' => $item->repition,
                    ];

                    $f[] = $exerciseDetails;
                }
            }
        } else {
            $Eid = Level_Body::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $buildId = $item->buildmuscle_id;

                $build = Building_Muscle::where('id', $buildId)->first();

                if ($build) {
                    $exerciseDetails = [
                        'id'=>$build->id,
                        'name' => $build ->name,
                        'url' => $build ->url_gif,
                        'detail' => $build->detail,
                        'duration' => $item->duration,
                        'sets' => $item->set,
                        'repetition' => $item->repition,
                    ];

                    $f[] = $exerciseDetails;
                }
            }

        }
        return response()->json($f);
    }


    // اذا اختار اليوزر يغير الهدف والليفل

    public function exercise(Request $request)
    {
        $id = Auth::id();

        Trainees::where('user_id', $id)->update([
            'target' => $request->target,
            'level' => $request->level
        ]);
        if ($request->level == 'advanced') {
            $level = '3';
        } elseif ($request->level == 'middle') {
            $level = '2';
        } else {
            $level = '1';
        }

        $f = [];

        if ($request->target == 'Get Toned') {


            $Eid = Level_Fitness::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $fitnessId = $item->fitness_id;

                $fitness = Fitness::where('id', $fitnessId)->first();

                if ($fitness) {
                    $exerciseDetails = [
                        'id'=>$fitness->id,
                        'name' => $fitness->name,
                        'url' => $fitness->url_gif,
                        'detail' => $fitness->detail,
                        'duration' => $item->duration,
                        'sets' => $item->set,
                        'repetition' => $item->repition,
                    ];

                    $f[] = $exerciseDetails;
                }
            }
        } elseif ($request->target == 'Losing Weight') {
            $Eid = Level_Losing::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $losingId = $item->Losing_id;

                $Losing_Width = Losing_Width::where('id', $losingId)->first();

                if ($Losing_Width) {
                    $exerciseDetails = [
                        'id'=>$Losing_Width ->id,
                        'name' => $Losing_Width ->name,
                        'url' => $Losing_Width ->url_gif,
                        'detail' => $Losing_Width ->detail,
                        'duration' => $item->duration,
                        'sets' => $item->set,
                        'repetition' => $item->repition,
                    ];

                    $f[] = $exerciseDetails;
                }
            }
        } else {
            $Eid = Level_Body::where('level_id', $level)->get();

            foreach ($Eid as $item) {
                $buildId = $item->buildmuscle_id;

                $build = Building_Muscle::where('id', $buildId)->first();

                if ($build) {
                    $exerciseDetails = [
                        'id'=>$build->id,
                        'name' => $build ->name,
                        'url' => $build ->url_gif,
                        'detail' => $build->detail,
                        'duration' => $item->duration,
                        'sets' => $item->set,
                        'repetition' => $item->repition,
                    ];

                    $f[] = $exerciseDetails;
                }
            }

        }
        return response()->json($f);
    }

    // for modify
    public function addex(Request $request)
    {
        $id=Auth::id();
        $idt=Trainees::where('user_id', $id)->value('id');
        $target=Trainees::where('user_id', $id)->value('target');
        $insertData = [];
        if ($target == 'Losing Weight') {
            foreach($request->exercise as $key=> $value) {
                $insertData[] = [
                    'day' => $request->day,
                    'trainees_id'=>$idt,
                    'done'=>false,
                    'Losing_id'=>$request->exercise[$key]
                          ];
            }
            Losing_Plan::insert($insertData);
        } elseif($target == 'Get Toned') {

            foreach($request->exercise as $key=> $value) {

                $insertData[] = [
                    'day' => $request->day,
                'trainees_id'=>$idt,
                'done'=>false,
                'fitnesses_id'=>$request->exercise[$key]
                          ];
            }

            Fitness_plan::insert($insertData);
        } else {

            foreach($request->exercise as $key=> $value) {

                $insertData[] = [
                    'day' => $request->day,
                'trainees_id'=>$idt,
                'done'=>false,
                'buildmuscle_id'=>$request->exercise[$key]
                          ];
            }
            Plan::insert($insertData);
        }

    }
    // for change
    public function addexforchange(Request $request)
    {
        $id = Auth::id();
        $idt = Trainees::where('user_id', $id)->value('id');
        $target = Trainees::where('user_id', $id)->value('target');
        $insertData = [];

        if ($target == 'Losing Weight') {


            foreach ($request->exercise as $key => $value) {
                $insertData[] = [
                    'day' => $request->day,
                    'trainees_id' => $idt,
                    'done' => false,

                    'Losing_id' => $request->exercise[$key]
                ];
            }

            Losing_Plan::insert($insertData);
        } elseif ($target == 'Get Toned') {


            foreach ($request->exercise as $key => $value) {
                $insertData[] = [
                    'day' => $request->day,
                    'trainees_id' => $idt,
                    'done' => false,

                    'fitnesses_id' => $request->exercise[$key]
                ];
            }

            Fitness_plan::insert($insertData);
        } else {


            foreach ($request->exercise as $key => $value) {
                $insertData[] = [
                    'day' => $request->day,
                    'trainees_id' => $idt,
                    'done' => false,

                    'buildmuscle_id' => $request->exercise[$key]
                ];
            }

            Plan::insert($insertData);
        }
    }

    public function delete(Request $request)
    {
        $id = Auth::id();
        $idt = Trainees::where('user_id', $id)->value('id');
        $target = Trainees::where('user_id', $id)->value('target');

        if ($target == 'Losing Weight') {

            Losing_Plan::where('trainees_id', $idt)->where('day', $request->day)->whereIn('Losing_id', $request->exercise)->delete();
        } elseif ($target == 'Get Toned') {

            Fitness_plan::where('trainees_id', $idt)->where('day', $request->day)->whereIn('fitnesses_id', $request->exercise)->delete();
        } else {

            Plan::where('trainees_id', $idt)->where('day', $request->day)->whereIn('buildmuscle_id', $request->exercise)->delete();
        }
    }

    public function deleteplan()
    {
        $id = Auth::id();
        $idt = Trainees::where('user_id', $id)->value('id');
        $target = Trainees::where('user_id', $id)->value('target');

        if ($target == 'Losing Weight') {
            Losing_Plan::where('trainees_id', $idt)->delete();
        } elseif ($target == 'Get Toned') {
            Fitness_plan::where('trainees_id', $idt)->delete();
        } else {
            Plan::where('trainees_id', $idt)->delete();

        }


    }

    public function evaluation($id)

    {
        $idt = Trainees::where('user_id', $id)->value('id');
        $trainee = Trainees::find($idt);
        if($trainee->target == 'Build Musle') {
            $complete_exercises = DB::table('plan')
                ->where('done', 1)
                ->where('trainees_id', $id)
                ->count();

            $total_exercises = DB::table('plan')
            ->where('trainees_id', $id)
            ->count();

        } elseif($trainee->target == 'Losing Weight') {
            $complete_exercises = DB::table('losing_plan')
                ->where('done', 1)
                ->where('trainees_id', $id)
                ->count();

            $total_exercises= DB::table('losing_plan')
            ->where('trainees_id', $id)
            ->count();
        } else {
            $complete_exercises = DB::table('fitness_plans')
                ->where('done', 1)
                ->where('trainees_id', $id)
                ->count();

            $total_exercises = DB::table('fitness_plans')
            ->where('trainees_id', $id)
            ->count();
        }

        $progress_percentage = ($complete_exercises/$total_exercises)*100;
        return response()->json($progress_percentage, 200);
    }




    public function add_exe_byadmin(Request $request){
        if($request->level == 'advanced')
        {
                $level= 3;
            }
        elseif($request->level == 'middle' ){
           $level= 2;
        }

        else {
           $level= 1;
              }

      if ($request->target=='Losing Weight'){
       $add=Losing_Width::create([
            'name' => $request->exe_name,
            'url_gif'=>$request->url_gif,
            'detail'=>$request->detail,
        ]);

        Level_Losing::create([
            'set'=>$request->sets,
            'repition'=>$request->repition,
            'duration'=>$request->duration,
            'level_id'=>$level,
            'Losing_id'=>$add->id

        ]);
     }

     elseif ($request->target=='Build Musle'){
        $add=Building_Muscle::create([
             'name' => $request->exe_name,
             'url_gif'=>$request->url_gif,
             'detail'=>$request->detail,
         ]);

         Level_Body::create([
             'set'=>$request->sets,
             'repition'=>$request->repition,
             'duration'=>$request->duration,
             'level_id'=>$level,
             'buildmuscle_id'=>$add->id,
             'target_muscle'=>$request->target_muscle,

         ]);
      }
      else{
        $add=Fitness::create([
            'name' => $request->exe_name,
            'url_gif'=>$request->url_gif,
            'detail'=>$request->detail,
        ]);

        Level_Fitness::create([
            'set'=>$request->sets,
            'repition'=>$request->repition,
            'duration'=>$request->duration,
            'level_id'=>$level,
            'fitness_id'=>$add->id,

        ]);

      }


    }

    public function delete_exe_byadmin(Request $request){
        if ($request->target=='Losing Weight'){
           $losing= Losing_Width::where('id',$request->id)->delete();
           $l=Level_Losing::where('Losing_id',$request->id)->delete();

        }
        elseif ($request->target=='Build Musle'){
          $build=Building_Muscle::where('id',$request->id)->delete();
          $l=Level_Body::where('buildmuscle_id',$request->id)->delete();
        }
        else{
          $fitness=Fitness::where('id',$request->id)->delete();
          $l=Level_Fitness::where('fitness_id',$request->id)->delete();
        }

    }
    //Calories Burned = MET Value × Weight in kg × Duration in hours
    public function calculate_burned_calories(Request $request){
        $id=Auth::id();
        $idt=Trainees::where('user_id', $id)->value('id');
         $trainer=Trainees::find($idt);
        $met=Level::where('level',$trainer->level)->value('met');
        $weight=$trainer->weight;
        $duration=$request->duration/60;
        $burned_calories=$met*$weight*$duration;
        return $burned_calories;



    }




}
