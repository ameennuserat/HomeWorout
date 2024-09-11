<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Level;
class Building_Muscle extends Model
{
    use HasFactory;
    protected $table='building_muscles';
    public $fillable = ['name',
    'detail',
    'url_gif'];


    public function levels(){

        return $this->belongsToMany(Level::class,'level_bodies','level_id','buildmuscle_id');
     }

    

     public function trainees(){

        return $this->belongsToMany(Trainees::class,'plan','trainess_id','buildmuscle_id');
     }
     //,'level__bodies','bodybuilding_id','level_id'
}
