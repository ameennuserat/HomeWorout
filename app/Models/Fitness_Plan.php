<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitness_Plan extends Model
{
    use HasFactory;
    public $table = 'fitness_plans';
    public $fillable = ['done','day','trainees_id','fitnesses_id'];

}
