<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peliculas_id' => 'required|exists:peliculas,id',
            'content' => 'required|string|max:1000',
        ]);

        Comment::create([
            'user_id' => Auth::id(),
            'peliculas_id' => $request->peliculas_id,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Comment added successfully');
    }
}
