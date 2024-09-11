<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class result extends Model
{
    use HasFactory;
    protected $table = 'results';
    protected $fillable = ['day','time','calorie','date','trainees_id'];
    public function trainee(){
        return $this->belongsTo(Trainees::class,'trainees_id');
    }
}
