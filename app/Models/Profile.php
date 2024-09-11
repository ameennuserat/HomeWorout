<?php

namespace App\Models;

use App\Models\Trainees;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    public $table = 'profiles';
    public $fillable = ['bmi',
    'fat_percentage','photo','trainees_id','evaluaiton'];


  public function trainees(){
    return $this->belongsTo(Trainees::class);
}

}
