<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_Fitness extends Model
{
    use HasFactory;
    public $table = 'level_fitnesses';
    public $fillable =['level_id','fitness_id','set','repition','duration'];
}
