
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

                        <h1 class="text-2xl font-bold mb-4">Peliculas</h1>

                        <!-- Botón Agregar -->
                        <a href="{{ route('posts.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">Agregar</a>

                        <!-- Mensaje de éxito -->
                        <div class="alert alert-success mt-4">
                            @if(session('success'))
                                {{ session('success') }}
                            @endif
                        </div>
                        
                        <!-- Tabla de posts -->
                        <table class="w-full divide-y divide-gray-200 mt-4 table-fixed">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Título</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Slug</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Descripcion</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Contenido</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Imagen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Categoría</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200">
                                @foreach($data as $post)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">{{ $post->id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">{{ $post->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">{{ $post->slug }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">{{ $post->description }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">{{ $post->content }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($post->image)
                                        <img src="{{ asset('images/' . $post->image) }}" alt="{{ $post->title }}" class="max-w-full h-auto">
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $post->category_id }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('posts.edit', $post->id) }}" class="inline-block mr-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-6 h-6 text-yellow-500">
                                                <path d="M471.6 21.7c-21.9-21.9-57.3-21.9-79.2 0L362.3 51.7l97.9 97.9 30.1-30.1c21.9-21.9 21.9-57.3 0-79.2L471.6 21.7zm-299.2 220c-6.1 6.1-10.8 13.6-13.5 21.9l-29.6 88.8c-2.9 8.6-.6 18.1 5.8 24.6s15.9 8.7 24.6 5.8l88.8-29.6c8.2-2.7 15.7-7.4 21.9-13.5L437.7 172.3 339.7 74.3 172.4 241.7zM96 64C43 64 0 107 0 160V416c0 53 43 96 96 96H352c53 0 96-43 96-96V320c0-17.7-14.3-32-32-32s-32 14.3-32 32v96c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32h96c17.7 0 32-14.3 32-32s-14.3-32-32-32H96z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-6 h-6">
                                                    <path fill="currentColor" d="M400 64h-88v-8c0-17.7-14.3-32-32-32h-96c-17.7 0-32 14.3-32 32v8H48c-13.3 0-24 10.7-24 24v32c0 13.3 10.7 24 24 24h24v336c0 26.5 21.5 48 48 48h208c26.5 0 48-21.5 48-48V144h24c13.3 0 24-10.7 24-24v-32c0-13.3-10.7-24-24-24zM176 56c0-4.4 3.6-8 8-8h80c4.4 0 8 3.6 8 8v8h-96v-8zm184 432c0 8.8-7.2 16-16 16H96c-8.8 0-16-7.2-16-16V144h280v344zm-40-224H128c-8.8 0-16-7.2-16-16s7.2-16 16-16h192c8.8 0 16 7.2 16 16s-7.2 16-16 16z" />
                                                </svg>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- Paginación -->
                        <div class="mt-4">
                                @if($data->count())
                                    {{ $data->links('vendor.pagination.semantic-ui') }}
                                @else
                                    <p>No hay posts disponibles.</p>
                                @endif
                        </div>
                        
                    </div>   
                </div>
            </div>
        </div>
   
    </x-app-layout>


   
   
