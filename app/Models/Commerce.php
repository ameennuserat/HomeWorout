<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commerce extends Model
{
    use HasFactory;
    protected $table = 'commerces';
    protected  $fillable = ['product_name','url','type','price','amount'];

    public function trainees(){
        return $this->belongsToMany(Trainees::class,'commerce_trainers','trainees_id','commerce_id');
     }

}
