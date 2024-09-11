<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commerce_Trainer extends Model
{
    use HasFactory;
    protected $table = 'commerce_trainers';
    protected  $fillable = ['discount','trainees_id','commerce_id'];

}
