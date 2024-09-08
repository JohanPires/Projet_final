<?php

namespace App\Models;

use App\Models\Exercice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
    ];

    public function exercices()
    {
        return $this->belongsToMany(Exercice::class, 'training_exercice')
                    ->withPivot('series', 'repetitions')
                    ->withTimestamps();
    }
}
