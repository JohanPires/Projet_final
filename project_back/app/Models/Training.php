<?php

namespace App\Models;

use App\Models\Exercice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom', 'user_id'
    ];

    public static function boot() {
        parent::boot();

        static::deleting(function($training) {
            $training->exercices()->delete();
        });
    }

    public function exercices()
    {
        return $this->hasMany(Exercice::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
