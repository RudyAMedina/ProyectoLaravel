<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'peliculas_id', 'rating'];
    public function pelicula()
    {
        return $this->belongsTo(peliculas::class, 'peliculas_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
