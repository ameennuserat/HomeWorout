<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply_reaction extends Model
{
    use HasFactory;
    public $fillable = ['reply_id','user_id'];
}
