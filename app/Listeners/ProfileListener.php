<?php

namespace App\Listeners;

use App\Models\Profile;
use App\Models\Trainees;
use App\Events\ProfileEvent;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProfileListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(ProfileEvent $event): void
    {

        $trainer=Trainees::find($event->trainee->id);
        $response = Http::withHeaders([
            'x-rapidapi-key' => 'b0c5aeb4b6msh58d600732a9a1f0p10f9b6jsn6c5783407248',
            'x-rapidapi-host' => 'fitness-calculator.p.rapidapi.com',

        ])->get('https://fitness-calculator.p.rapidapi.com/bmi', [
           'weight' => $trainer->weight,
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


        Profile::create([
            'bmi'=>$bmi,
            'evaluaiton'=> $evaluation,
            'trainees_id'=>$trainer->id,
           'fat_percentage'=>$fatpercentage,
          ]);

















    }
}
