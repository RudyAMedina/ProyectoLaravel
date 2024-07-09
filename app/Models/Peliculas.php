<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Peliculas extends Model
{
    use HasFactory;
    use HasRoles;
    protected $table = 'peliculas';

    protected $fillable = ['title', 'slug', 'content', 'category_id', 'description',
    'posted', 'image'];

    public function category()
        {
            return $this->belongsTo(Categorias::class, 'category_id');
        }
    public function ratings()
        {
        return $this->hasMany(Rating::class);
        }

    public function averageRating()
        {
        return $this->ratings()->avg('rating');
        }
        
    public function comments()
        {
            return $this->hasMany(Comment::class);
        }
}