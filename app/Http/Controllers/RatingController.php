<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peliculas_id' => 'required|exists:peliculas,id',
            'rating' => 'required|integer|min:1|max:5',
            ]);

        $rating = Rating::updateOrCreate(
            ['user_id' => Auth::id(), 'peliculas_id' => $request->peliculas_id],
            ['rating' => $request->rating]
            );

        return back()->with('success', 'Rating submitted successfully');
    }
}
