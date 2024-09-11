<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Trainees;

class Losing_Width extends Model
{
    use HasFactory;
    protected $table='losing_widths';
    public $fillable = ['name',
    'detail',
    'url_gif'];

    public function trainees(){
        return $this->belongsToMany(Trainees::class,'losing_plan','trainess_id','losingwidth_id');
     }
     public function levels(){

        return $this->belongsToMany(Level::class,'level_losing','level_id','Losing_id');
     }
}
