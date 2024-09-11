<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use App\Models\Trainees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getprofile(){
     $id=Auth::id();
     $idt=Trainees::where('user_id',$id)->value('id');
     $idp=Profile::where('trainees_id',$idt)->get('id');
     $name=User::where('id',$id)->get('name');
     $fatpercentage=Profile::where('trainees_id',$idt)->get('fat_percentage');
     $evaluaiton=Profile::where('trainees_id',$idt)->get('evaluaiton');
     $bmi=Profile::where('trainees_id',$idt)->get('bmi');
     $photo=Profile::where('trainees_id',$idt)->get('photo');
   $weight=Trainees::where('user_id',$id)->get('weight');
    $tall=Trainees::where('user_id',$id)->get('tall');
    $target_weight=Trainees::where('user_id',$id)->get('target_weight');
    $age=Trainees::where('user_id',$id)->get('age');

    $profile = array();
   $profile=[$idp,$name,$photo,$fatpercentage,$evaluaiton,$bmi,$weight,$tall,$target_weight,$age];

   return $profile;
}

public function updateweight(Request $request){
    $id=Auth::id();
    $validator = Validator::make($request->all(), [
        'weight' => 'required|integer',
    ]);
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
    }
    $trainer=Trainees::where('user_id',$id)->first();
    $trainer->weight = $request->weight;
    $trainer->save();

    $response = Http::withHeaders([
        'x-rapidapi-key' => 'b0c5aeb4b6msh58d600732a9a1f0p10f9b6jsn6c5783407248',
        'x-rapidapi-host' => 'fitness-calculator.p.rapidapi.com',

    ])->get('https://fitness-calculator.p.rapidapi.com/bmi', [
       'weight' => $request->weight ,
        'height' => $trainer->tall,
        'age' => $trainer->age,
    ]);
    $data = json_decode($response->getBody());
    $bmi = $data->data->bmi;
    $evaluation = $data->data->health;


    $response1 = Http::withHeaders([
        'x-rapidapi-key' => 'b0c5aeb4b6msh58d600732a9a1f0p10f9b6jsn6c5783407248',
        'x-rapidapi-host' => 'mega-fitness-calculator1.p.rapidapi.com',

    ])->get('https://mega-fitness-calculator1.p.rapidapi.com/bfp', [
       'weight' => $trainer->weight,
        'height' => $trainer->tall,
        'age' => $trainer->age,
        'gender' => $trainer->gender,
    ]);
    $data1 = json_decode($response1->getBody());
    $fatpercentage=$data1->info->bfp;

    $idt=Trainees::where('user_id',$id)->value('id');
     $profile=Profile::where('trainees_id',$idt)->first();
     $profile->bmi=$bmi;
     $profile->fat_percentage=$fatpercentage;
     $profile->evaluaiton=$evaluation;
     $profile->save();

}


public function updatetargetweight(Request $request){
    $id=Auth::id();
    $validator = Validator::make($request->all(), [
        'target_weight' => 'required|integer',
    ]);
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
    }
    $trainer=Trainees::where('user_id',$id)->first();
    $trainer->target_weight = $request->target_weight;
    $trainer->save();

}


public function updateage(Request $request){
    $id=Auth::id();
    $validator = Validator::make($request->all(), [
        'age' => 'required|integer',
    ]);
    if($validator->fails()){
        return response()->json($validator->errors()->toJson(), 400);
    }
    $trainer=Trainees::where('user_id',$id)->first();
    $trainer->age = $request->age;
    $trainer->save();

}

public function addphoto(Request $request){
     $id=Auth::id();
     $request ->validate([
        'photo' => 'required',
    ]);
    $photo = $request->photo->getClientOriginalExtension();
    $photo_name = time().'.'.$photo;
    $path = 'profileimages';
    $request->photo->move($path,$photo_name);

    $idt=Trainees::where('user_id',$id)->value('id');
    $profile=Profile::where('trainees_id',$idt)->first();
    $profile->photo=$photo_name;
    $profile->save();

}



// use ImageTrait;

// public function __construct()
// {
//     $this->middleware('auth:api');
// }

// public function AddProfileInfo(Request $request)
// {

//     $validator = Validator::make($request->all(), [
//         'bio' => 'required|string|max:1000',
//         'phone' => 'required|string|min:10|max:15',
//         'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
//     ]);

//     if ($validator->fails()) {
//         return response()->json($validator->errors(), 422);
//     }

//     $imagename = $this->storimage($request->image);

//     $expert = Expert::create([
//         'image' => $imagename,
//         'phone' => $request->phone,
//         'bio' => $request->bio,
//         'user_id' => Auth::id()
//     ]);

//     return response()->json($expert, 200);
// }


}
