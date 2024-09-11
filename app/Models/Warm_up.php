<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warm_up extends Model
{
    use HasFactory;
    public $fillable = ['url_gif','detail','name','type','sets','repetition','duration'];
}
