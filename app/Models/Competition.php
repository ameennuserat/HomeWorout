<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competition extends Model
{
    use HasFactory;
    protected $table = 'competitions';
    protected $fillable = ['score','trainees_id'];

    public function trainee()
    {
        return $this->belongsTo(Trainees::class, 'trainees_id');
    }
}
