<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fitness extends Model
{
    use HasFactory;
    public $table = 'fitness';
    public $fillable =['name','detail','url_gif'];

     public function trainees()
     {
         return $this->belongsToMany(Trainees::class,'fitness_plans','trainess_id','fitness_id');
    }

     public function levels()
    {

        return $this->belongsToMany(Level::class,'level_fitness','level_id','fitness_id');
    }



}
