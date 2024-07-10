<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

</head>

<body class="font-sans antialiased dark:bg-black dark:text-white/50">
    <div class="container mx-auto">
        <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                <div class="flex items-center lg:col-start-1">
                    <!-- Logo -->
                    <a href="{{ url('/') }}"
                       class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16">
                    </a>
                </div>
                <div class="flex items-center justify-end lg:col-start-3 lg:justify-end mt-6">
                    <!-- Menú de usuario -->
                    <div class="p-4 rounded-lg shadow-md">
                        @if (Route::has('login'))
                            @auth
                                <div class="hidden sm:flex sm:items-center sm:ms-6">
                                    <x-dropdown align="right" width="48">
                                        <x-slot name="trigger">
                                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                                <div>{{ Auth::user()->name }}</div>
                                                <div class="ml-1">
                                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                    </svg>
                                                </div>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('profile.edit')">
                                                {{ __('Perfil') }}
                                            </x-dropdown-link>
                                            <!-- Authentication -->
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <x-dropdown-link :href="route('logout')"
                                                                 onclick="event.preventDefault();
                                                                 this.closest('form').submit();">
                                                    {{ __('Cerrar Sesión') }}
                                                </x-dropdown-link>
                                            </form>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                   class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                    Ingresar
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                       class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                                        Registrarse
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
        </header>
        <main class="mt-6 container mx-auto px-4">
            <form action="{{ route('peliculas.lista') }}" method="GET" class="mb-8">
                <div class="flex justify-center">
                    <input type="text" name="search" placeholder="Buscar por nombre o categoría"
                        class="px-4 py-2 border rounded-l-lg focus:outline-none text-black">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg">Buscar</button>
                </div>
            </form>

            <div class="container mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mx-auto">
                
                <h1 class="text-3xl font-bold mb-4">{{ $pelicula->title }}</h1>

                <!-- aqui mostramos la calificacion sacando un promedio y mostrandolo con estrellas-->
                <h3>Calificación: {{ number_format($pelicula->averageRating(), 2) }}</h3>
                <div class="flex items-center">
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= floor($pelicula->averageRating()))
                            <!-- Estrella llena -->
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927C9.337 2.036 10.663 2.036 10.951 2.927L12.084 6.518L15.967 7.03C16.919 7.155 17.261 8.28 16.541 8.879L13.812 11.137L14.625 14.901C14.809 15.832 13.774 16.538 13.004 15.997L9.999 13.982L6.995 15.997C6.225 16.538 5.19 15.832 5.374 14.901L6.187 11.137L3.458 8.879C2.738 8.28 3.08 7.155 4.032 7.03L7.915 6.518L9.049 2.927Z"/>
                            </svg>
                        @elseif ($i - 0.5 <= $pelicula->averageRating())
                            <!-- Media estrella -->
                            <svg class="w-6 h-6 text-yellow-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <defs>
                                    <linearGradient id="half">
                                        <stop offset="50%" stop-color="currentColor"/>
                                        <stop offset="50%" stop-color="transparent"/>
                                    </linearGradient>
                                </defs>
                                <path fill="url(#half)" d="M9.049 2.927C9.337 2.036 10.663 2.036 10.951 2.927L12.084 6.518L15.967 7.03C16.919 7.155 17.261 8.28 16.541 8.879L13.812 11.137L14.625 14.901C14.809 15.832 13.774 16.538 13.004 15.997L9.999 13.982L6.995 15.997C6.225 16.538 5.19 15.832 5.374 14.901L6.187 11.137L3.458 8.879C2.738 8.28 3.08 7.155 4.032 7.03L7.915 6.518L9.049 2.927Z"/>
                            </svg>
                        @else
                            <!-- Estrella vacía -->
                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927C11.337 2.036 12.663 2.036 12.951 2.927L14.084 6.518L17.967 7.03C18.919 7.155 19.261 8.28 18.541 8.879L15.812 11.137L16.625 14.901C16.809 15.832 15.774 16.538 15.004 15.997L11.999 13.982L8.995 15.997C8.225 16.538 7.19 15.832 7.374 14.901L8.187 11.137L5.458 8.879C4.738 8.28 5.08 7.155 6.032 7.03L9.915 6.518L11.049 2.927Z"/>
                            </svg>
                        @endif
                    @endfor
                </div>

                <!-- aqui es donde se trae y carga la pelicula -->
                <iframe src="{{ $pelicula->slug }}" 
                        sandbox="allow-same-origin allow-scripts" width=80% height="600px"
                        scrolling="no" 
                        frameborder="0" 
                        allowfullscreen="true">
                </iframe>

                <!-- este div contiene la manera en que calificamos la pelicula -->
                <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mx-auto">
                    <h3 class="text-xl font-semibold mb-4 text-center">Califica esta película</h3>
                    <form action="{{ route('rate') }}" method="POST" class="flex flex-col items-center">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">

                        <div class="flex items-center space-x-1">
                            @for($i = 1; $i <= 5; $i++) <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}"
                                class="hidden peer" required>
                                <label for="star{{ $i }}"
                                    class="cursor-pointer text-gray-300 hover:text-yellow-400 text-3xl peer-checked:text-yellow-500">
                                    ★
                                </label>
                                @endfor
                        </div>

                        <button type="submit"
                            class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Enviar Calificación
                        </button>
                    </form>
                </div>

                <style>
                .rating input:checked~label {
                    color: #FF2D20;
                    /* Cambia el color de las estrellas al seleccionar */
                }

                .rating label:hover {
                    color: #FFD700;
                    /* Cambia el color de las estrellas al pasar el cursor */
                }
                </style>


                <!-- este div contiene todo para generar un comentario -->
                <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mx-auto">
                    <h3 class="text-xl font-semibold mb-4">Agregar comentario:</h3>
                    <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">

                        <div>
                            <textarea name="content"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#FF2D20] resize-none text-black"
                                rows="4" required placeholder="Escribe tu comentario aquí..."></textarea>
                        </div>

                        <button type="submit"
                            class="mt-6 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            Enviar comentario
                        </button>
                    </form>
                </div>

                <!-- este div trae los comentarios de la pelicula y los muestra en la pagina -->
                <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mx-auto">
                    <h3 class="text-xl font-semibold mb-4">Comentarios:</h3>

                    @foreach($pelicula->comments as $comment)
                    <div class="mb-4 p-4 bg-gray-100 rounded-lg shadow-sm">
                        <div class="flex items-center space-x-2 mb-2">
                            <div
                                class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-white font-bold text-xl">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                            <div class="text-gray-800 font-semibold">{{ $comment->user->name }}</div>
                        </div>
                        <p class="text-gray-700">{{ $comment->content }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </main>
    </div>

    <footer class="py-16 text-center text-sm text-black dark:text-white/70">
        Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
    </footer>

</body>

</html>