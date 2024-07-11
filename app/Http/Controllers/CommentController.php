<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class CommentController extends Controller
{
    public function index($userId)
    {
        $user = User::find($userId);
   
        if (!$user) {
            abort(404);
        }
       
        // Paginar los comentarios del usuario
        $comentarios = $user->comments()->paginate(10); // 10 comentarios por página
       
        return view('userdashboard', compact('comentarios'));
    }

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
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return redirect()->route('dashboard')->with('success', 'Comentario eliminado.');
    }

    public function update(Request $request, $id)
    {

        //dd($comment);
        $request->validate([
            'comment' => 'required|string|max:1000',
        ]);
        $comentario = Comment::findOrFail($id);

        $comentario->content = $request->comment;
        $comentario->save();

        return redirect()->back()->with('success', 'Comentario actualizado correctamente');

    }
}
