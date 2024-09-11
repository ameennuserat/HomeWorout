<?php

namespace App\Models;

//use App\Models\trainees;
use App\Models\User;
use App\Models\Fitness;
use App\Models\Losing_Width;
use App\Models\Building_Muscle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Trainees extends Model
{
    use HasFactory;
    protected $table = 'trainees';
    protected $fillable = ['gender','weight','tall','target','illness','level','days_number','age','has_sale','target_weight','target_musle','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function buildingmuscle()
    {
        return $this->belongsToMany(Building_Muscle::class, 'plan', 'trainess_id', 'buildmuscle_id');
    }


    public function fitness()
    {
        return $this->belongsToMany(Fitness::class, 'fitness_plans', 'trainess_id', 'fitness_id');
    }


    public function challeng()
    {
        return $this->belongsToMany(Challenge::class, 'challenge_trainees', 'trainees_id', 'challenge_id');
    }


    public function losingwidth()
    {
        return $this->belongsToMany(Losing_Width::class, 'losing_plan ', 'trainess_id', 'losingwidth_id');
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function commerce()
    {
        return $this->belongsToMany(Commerce::class, 'commerce_trainers', 'trainees_id', 'commerce_id');
    }

    public function result()
    {
        return $this->hasMany(Result::class, 'trainees_id');
    }

    public function competition(){
        return $this-> hasOne(Competition::class,'trainees_id');
    }


}
