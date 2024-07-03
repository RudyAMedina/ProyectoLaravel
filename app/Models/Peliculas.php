<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peliculas extends Model
{
    use HasFactory;
    protected $table = 'peliculas';

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'description',
    'posted', 'image'];

    public function category()
        {
            return $this->belongsTo(Categorias::class, 'category_id');
        }
}