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
        'series',
        'repetitions'
    ];
    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
