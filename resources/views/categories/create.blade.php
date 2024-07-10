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
    
                    <h1 class="text-2xl font-bold mb-6">Crear categoría</h1>
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="titulo" class="block text-sm font-medium text-white-700 mb-2">Título</label>
                            <input type="text" class="form-input w-full border-gray-300 rounded-md text-black" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-4">
                            <label for="descripcion" class="block text-sm font-medium text-white-700 mb-2">Descripción</label>
                            <input type="text" class="form-input w-full border-gray-300 rounded-md text-black" id="descripcion" name="descripcion" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
@endrole