<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    public $table = 'plan';
    public $fillable = ['done','day','trainees_id','buildmuscle_id'];








}
