<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    public $fillable = ['body','user_id','reaction_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'post_reactions','post_id','user_id');
    }

    public function comment(){
        return $this-> hasMany(Comment::class,'post_id');
    }

    public function image(){
        return $this-> hasMany(Post_image::class,'post_id');
    }
}
