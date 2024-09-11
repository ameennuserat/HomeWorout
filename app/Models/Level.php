<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Building_Muscle;

class Level extends Model
{
    use HasFactory;
    protected $table   =   'levels';
    public $fillable = ['level','met'];
    public function BuildingMuscle()
    {
        return $this->belongsToMany(Building_Muscle::class, 'level_bodies', 'level_id', 'buildmuscle_id');
    }


    public function fitness()
    {
        return $this->belongsToMany(Fitness::class, 'level_fitnesses', 'level_id', 'fitness_id');
    }


    public function losingweight()
    {
        return $this->belongsToMany(losing_widths::class, 'level_losing', 'level_id', 'Losing_id');
    }
}
