<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    use HasFactory;
    protected $fillable = ['titulo', 'descripcion'];
    public function peliculas()
        {
            return $this->hasMany(Peliculas::class, 'category_id');
        }
}
