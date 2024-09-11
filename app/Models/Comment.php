<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $fillable = ['body','post_id','user_id','reaction_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'comment_reactions','comment_id','user_id');
    }

    public function post(){
        return $this-> belongsTo(Post::class,'post_id');
    }

    public function reply(){
        return $this-> hasMany(Reply::class,'comment_id');
    }
}
