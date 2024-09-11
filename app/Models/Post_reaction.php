<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post_reaction extends Model
{
    use HasFactory;
    public $fillable = ['post_id','user_id'];
}
