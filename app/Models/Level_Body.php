<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_Body extends Model

{

    use HasFactory;
    public $table = 'level_bodies';
    public $fillable =['level_id','buildmuscle_id','set','repition','duration','target_muscle'];




}
