<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competitions_time extends Model
{
    use HasFactory;
    public $fillable =['start_time','end_time'];

}
