<?php

namespace App\Models;

use App\Models\Training;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Exercice extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'description',
    ];

    public function seances()
    {
        return $this->belongsToMany(Training::class, 'trainnig_exercice')
                    ->withPivot('series', 'repetitions')
                    ->withTimestamps();
    }
}
