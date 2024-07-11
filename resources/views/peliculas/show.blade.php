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

<body class="font-sans antialiased bg-gray-900 text-white">
    <div class="container mx-auto font-sans antialiased bg-gray-900 text-white">

        <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3 bg-gray-800">
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
                                        <x-dropdown-link :href="route('dashboard')">
                                            {{ __('Panel') }}
                                        </x-dropdown-link>
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
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-r-lg">Buscar</button>
                </div>
            </form>

            <h1 class="text-3xl font-bold mb-4">{{ $pelicula->title }}</h1>
            <h3>Calificacion: {{ number_format($pelicula->averageRating(), 2) }}</h3>
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

            <iframe src="{{ $pelicula->slug }}" sandbox="allow-same-origin allow-scripts" width=80% height="600px"
                scrolling="no" frameborder="0" allowfullscreen="true"></iframe>

            <div class="mt-6 p-4 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md mx-auto">
                <!-- Calificación de Película -->
                <div class="rating-section mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Calificación de la película
                    </h3>
                    <form action="{{ route('rate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">
                
                        <div class="rating">
                            @for($i = 5; $i >= 1; $i--)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" />
                                <label for="star{{ $i }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 star-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        <br>
                        <button type="submit" class="btn btn-primary">Calificar</button>
                    </form>
                </div>

                <!-- Agregar Comentario -->
                <div class="comment-section mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-200">Agregar comentario:</h3>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">
                        <div class="form-group mb-4">
                            <textarea name="content"
                                class="form-control p-3 border rounded-lg w-full text-gray-900 dark:bg-gray-700 dark:text-gray-300"
                                rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar comentario</button>
                    </form>
                </div>

                <!-- Mostrar Comentarios -->
                <div class="w-full h-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8 dark:bg-gray-800 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-4">
                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">Últimos comentarios
                        </h5>
                    </div>

                    <div class="flow-root">
                        <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($pelicula->comments as $comment)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            width="40px" height="40px">
                                            <path
                                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0 ms-4">
                                        <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                            {{ $comment->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                    <div
                                        class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                                        <!-- Aquí puedes agregar alguna información adicional si es necesario -->
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>



                <style>
                /* Contenedor de calificación y comentarios */
                .rating-comments-container {
                    background-color: #f0f0f0;
                    /* Fondo claro */
                }

                .rating-comments-container .rating {
                    display: flex;
                    gap: 0.25rem;
                }

                .rating {
                    display: flex;
                    flex-direction: row-reverse;
                    justify-content: left;
                }
                .rating input {
                    display: none;
                }
                .rating label {
                    cursor: pointer;
                    width: 24px;
                    height: 24px;
                }
                .rating label svg {
                    fill: lightgray;
                    transition: fill 0.3s;
                }
                .rating input:checked ~ label svg,
                .rating label:hover ~ label svg,
                .rating label:hover svg {
                    fill: gold;
                }

                /* Estilo de los botones */
                .btn-primary {
                    background-color: #3b82f6;
                    /* Color de fondo azul */
                    color: white;
                    /* Color del texto */
                    padding: 0.5rem 1rem;
                    /* Espaciado del botón */
                    border-radius: 0.375rem;
                    /* Bordes redondeados */
                    transition: background-color 0.2s ease;
                    /* Transición suave para el color de fondo */
                }

                .btn-primary:hover {
                    background-color: #2563eb;
                    /* Color de fondo al pasar el ratón */
                }

                /* Estilos para el formulario de comentario */
                .form-control {
                    border: 1px solid #d1d5db;
                    /* Borde gris claro */
                }

                /* Estilos para el formulario de comentario en modo oscuro */
                .dark .form-control {
                    background-color: #1f2937;
                    /* Fondo oscuro */
                    border-color: #4b5563;
                    /* Borde gris oscuro */
                }

                /* Estilo para el área de comentarios */
                .comments-list .comment {
                    background-color: #ffffff;
                    /* Fondo blanco */
                    border: 1px solid #e5e7eb;
                    /* Borde gris claro */
                    color: #374151;
                    /* Texto gris oscuro */
                }

                .dark .comments-list .comment {
                    background-color: #111827;
                    /* Fondo oscuro */
                    border-color: #4b5563;
                    /* Borde gris oscuro */
                    color: #d1d5db;
                    /* Texto gris claro */
                }
                </style>

            </div>
            <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </footer>

</body>

</html>