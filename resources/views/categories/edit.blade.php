@role('administrador')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control de categorias') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1>Editar categoria</h1>
                    <form action="{{ route('categories.update', $category->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="titulo" class="block text-sm font-medium text-white-700 mb-2">titulo</label>
                            <input type="text" class="form-input w-full border-gray-300 rounded-md text-black" id="titulo" name="titulo" value="{{ old('titulo', $category->titulo) }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-white-700 mb-2">Descripción</label>
                            <textarea class="form-input w-full border-gray-300 rounded-md text-black" id="descripcion" name="descripcion">{{ old('descripcion', $category->descripcion) }}</textarea>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Actualizar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endrole