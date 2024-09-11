<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level_Losing extends Model
{
    use HasFactory;
    public $table = 'level_losings';
    public $fillable =['level_id','Losing_id','set','repition','duration'];
}
