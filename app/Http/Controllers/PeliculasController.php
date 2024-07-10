<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peliculas;
use App\Models\Categorias;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class PeliculasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peliculas = Peliculas::paginate(10);
        return view('dashboard', ['data' => $peliculas, 'type' => 'Peliculas']);
    }

    public function lista(Request $request)
    {
        $query = Peliculas::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('title', 'LIKE', "%{$search}%")
                ->orWhereHas('category', function($q) use ($search) {
                    $q->where('titulo', 'LIKE', "%{$search}%");
                });
        }

        $peliculas = $query->get();

        if ($request->filled('search')) {
            $categories = Categorias::whereHas('peliculas', function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('titulo', 'LIKE', "%{$search}%");
                  });
            })->with(['peliculas' => function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('titulo', 'LIKE', "%{$search}%");
                  });
            }])->get();
        } else {
            $categories = Categorias::with('peliculas')->get();
        }
    
        return view('welcome', compact('peliculas', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categorias::pluck('id', 'titulo');
        //dd($categories);
        return view('post.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request);
       $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|integer',
        'description' => 'nullable|string',
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'posted' => 'required|string|in:not,yes',
        ]);
    
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $data = $request->all();
        $data['image'] = $imageName;

        Peliculas::create($data);

        // Redireccionar a la lista de posts pagina 41 del pdf
        return redirect()->route('posts.index')
                        ->with('success', 'Agregado correctamente.');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pelicula = Peliculas::with('comments.user')->findOrFail($id);
        return view('peliculas.show', compact('pelicula'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Peliculas $post)
    {
        $categories = Categorias::pluck('titulo', 'id');
        return view('post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Peliculas $post)
    {
        //dd($request);
       $request->validate([
        'title' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'content' => 'required|string',
        'category_id' => 'required|integer',
        'description' => 'nullable|string',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'posted' => 'required|string|in:not,yes',
        ]);

        if ($request->hasFile('image')) {
            // eliminamos la imagen anterior si es que se carga una nueva imagen
            if ($post->image) {
                Peliculas::delete('images/' . $post->image);
            }
    
            // guardamos la imagen nueva
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $post->image = $imageName;
        }
    
        // Actualizamos otros campos del post
        $post->fill($request->except('image'));
        $post->save();
    
        return redirect()->route('posts.index', $post->id)->with('success', 'Pelicula actualizada');
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peliculas $peliculas)
    {
        $peliculas->delete();
        return redirect()->route('posts.index')->with('success', 'Registro eliminado.');
    }
}
