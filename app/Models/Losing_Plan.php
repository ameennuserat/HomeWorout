<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Losing_Plan extends Model
{
    use HasFactory;
    public $table = 'losing_plan';
    public $fillable = ['done','day','trainees_id','Losing_id'];
}
