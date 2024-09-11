<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Trainees;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable  implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
//mailpit
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'device_key',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function trainee(){
        return $this-> hasOne(Trainees::class,'user_id');
    }
    public function notification(){
        return $this-> hasOne(Notification::class,'user_id');
    }

    public function wallet(){
        return $this-> hasOne(Wallet::class,'user_id');
    }

    public function post(){
        return $this-> hasMany(Post::class,'user_id');
    }
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_reactions','post_id','user_id');
    }


    public function comment(){
        return $this-> hasMany(Comment::class,'user_id');
    }
    public function comments()
    {
        return $this->belongsToMany(Comment::class,'comment_reactions','comment_id','user_id');
    }



    public function reply(){
        return $this-> hasMany(Reply::class,'user_id');
    }
    public function replies()
    {
        return $this->belongsToMany(Reply::class,'reply_reactions','reply_id','user_id');
    }


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
