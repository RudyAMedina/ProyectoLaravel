<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Categorias extends Model
{
    use HasFactory;
    use HasRoles;
    protected $fillable = ['titulo', 'descripcion'];
    public function peliculas()
        {
            return $this->hasMany(Peliculas::class, 'category_id');
        }
}
