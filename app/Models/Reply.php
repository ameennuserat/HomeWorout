<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;
    public $fillable = ['body','comment_id','user_id','reaction_number'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'reply_reactions','reply_id','user_id');
    }
    public function comment(){
        return $this-> belongsTo(Comment::class,'comment_id');
    }
}
