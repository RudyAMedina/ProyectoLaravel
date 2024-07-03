<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categorias;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categorias = Categorias::paginate(10); 
        return view('categories.dashboard', ['data' => $categorias, 'type' => 'categorias']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        try {
            Categorias::create($request->all());
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria agregada.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Categorias $category)
    {
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categorias $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorias $category)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')
                         ->with('success', 'La categoria se actualizo.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorias $category)
    {
        $category->delete();

        return redirect()->route('categories.index')
                         ->with('success', 'Categoria eliminada.');
    }
}
