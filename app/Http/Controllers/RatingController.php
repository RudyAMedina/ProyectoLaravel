<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Peliculas;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RatingController extends Controller
{
    public function index($userId)
    {
        // Obtener el usuario por ID
        $user = User::find($userId);

        if (!$user) {
            abort(404);
        }

        // Obtener las calificaciones del usuario
        $calificaciones = $user->ratings()->paginate(10);

        return view('calificaciones.dashboard', compact('calificaciones'));
    }

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
    public function destroy(Rating $rating)
    {
        $rating->delete();
        return redirect()->route('calificaciones.index')->with('success', 'Calificación eliminada.');
    }

    public function update(Request $request, $id)
    {
     
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);
        $calificacion = Rating::findOrFail($id);

        $calificacion->rating = $request->rating;
        $calificacion->save();

        return redirect()->back()->with('success', 'La calificación actual se actualizo.');

    }

}
