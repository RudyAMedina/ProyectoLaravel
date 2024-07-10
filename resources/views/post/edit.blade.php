@role('administrador')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control de películas') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('posts.update', $post->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <h1>Editar</h1>
                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-white-700 mb-2">Titulo</label>
                            <input type="text" class="form-input w-full border-gray-300 rounded-md text-black" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="slug" class="block text-sm font-medium text-white-700 mb-2">Slug</label>
                            <input type="text" class="form-input w-full border-gray-300 rounded-md text-black" id="slug" name="slug" value="{{ old('slug', $post->slug) }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="content" class="block text-sm font-medium text-white-700 mb-2">Contenido</label>
                            <textarea id="content" class="form-input w-full border-gray-300 rounded-md text-black" name="content" required>{{ old('content', $post->content) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="category_id" class="block text-sm font-medium text-white-700 mb-2">Selecciona una categoría:</label>
                            <select name="category_id" id="category_id" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 text-black">
                                @foreach($categories as $id => $titulo)
                                    <option value="{{ $id }}" {{ old('category_id', $post->category_id) == $id ? 'selected' : '' }}>{{ $titulo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-white-700 mb-2">Descripción</label>
                            <textarea id="description" class="form-input w-full border-gray-300 rounded-md text-black" name="description" required>{{ old('description', $post->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-sm font-medium text-white-700 mb-2">Imagen</label>
                            @if ($post->image)
                                <div class="mb-4">
                                    <img src="{{ asset('images/' . $post->image) }}" alt="Current Image"  class="w-20 h-20 object-cover rounded-md">
                                </div>
                            @endif
                            <input type="file" class="form-input w-full border-gray-300 rounded-md text-black" name="image" id="image">
                        </div>

                        <div class="mb-4">
                            <label for="posted" class="block text-sm font-medium text-white-700 mb-2">Postear</label>
                            <select name="posted" id="posted" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500 focus:border-blue-500 text-black">
                                <option value="not" {{ old('posted', $post->posted) == 'not' ? 'selected' : '' }}>Not</option>
                                <option value="yes" {{ old('posted', $post->posted) == 'yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                        </div>

                        <br />
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
@endrole