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
    <div class="bg-gray-80 text-black/50 dark:bg-black dark:text-white/50">

        <header class="fixed top-0 left-0 w-full z-50 flex items-center justify-between py-4 bg-gray-800 shadow-md">
            <div class="flex items-center">
                <!-- Logo a la izquierda -->
                <a href="{{ url('/') }}"
                   class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-16">
                </a>
            </div>
            <!-- Buscador en el centro -->
            <div class="flex-grow flex justify-center">
                <form action="{{ route('peliculas.lista') }}" method="GET" class="mb-8 w-1/2">
                    <div class="flex">
                        <input type="text" name="search" placeholder="¿Qué quieres ver hoy?" class="px-4 py-2 border rounded-l-lg focus:outline-none text-black w-full">
                        <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-r-lg">Buscar</button>
                    </div>
                </form>
            </div>
            <!-- Login y registro a la derecha -->
            @if (Route::has('login'))
            <div class="flex items-center space-x-4">
                @auth
                <a href="{{ url('/dashboard') }}"
                   class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="40px" height="40px">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                        {{ Auth::user()->name }}
                    </div>
                </a>
                @else
                <a href="{{ route('login') }}"
                   class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Ingresar
                </a>
                @if (Route::has('register'))
                <a href="{{ route('register') }}"
                   class="rounded-md px-3 py-2 text-white ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white">
                    Registrarse
                </a>
                @endif
                @endauth
            </div>
            @endif
        </header>

        <main class="mt-28 container mx-auto px-6">
            <h1 class="text-3xl font-bold mb-4 text-white">{{ $pelicula->title }}</h1>
            <h3 class="text-1xl font-bold mb-4 text-white">Calificación: {{ number_format($pelicula->averageRating(), 2) }}</h3>
            <iframe src="{{ $pelicula->slug }}" sandbox="allow-same-origin allow-scripts" width="80%" height="600px"
                scrolling="no" frameborder="0" allowfullscreen="true"></iframe>

            <div class="rating-comments-container mt-8 p-6 bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
                <!-- Calificación de Película -->
                <div class="rating-section mb-6">
                    <h3 class="text-xl font-semibold mb-4 text-white dark:text-gray-200">Calificación de la película</h3>
                    <form action="{{ route('rate') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">

                        <div class="rating flex space-x-1 mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" class="hidden" />
                                <label for="star{{ $i }}" class="cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 star-icon" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.62L12 2 9.19 8.62 2 9.24l5.46 4.73L5.82 21z" />
                                    </svg>
                                </label>
                            @endfor
                        </div>
                        <button type="submit" class="btn-primary">Calificar</button>
                    </form>
                </div>

                <!-- Agregar Comentario -->
                <div class="comment-section mb-4">
                    <h3 class="text-xl font-semibold mb-4 text-white dark:text-gray-200">Agregar comentario:</h3>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">
                        <div class="form-group mb-4">
                            <textarea name="content" class="form-control p-3 border rounded-lg w-full text-gray-900 dark:bg-gray-700 dark:text-gray-300" rows="3" placeholder="Escribe tu comentario aquí..." required></textarea>
                        </div>
                        <button type="submit" class="btn-primary">Enviar comentario</button>
                    </form>
                </div>

                <!-- Mostrar Comentarios -->
                <div class="comments-list w-full bg-gray-900 dark:bg-gray-800 rounded-lg shadow-md">
                    <div class="p-4">
                        <h5 class="text-xl font-bold text-white dark:text-white mb-4">Últimos comentarios</h5>
                        <ul role="list" class="divide-y text-white dark:divide-gray-700">
                            @foreach($pelicula->comments as $comment)
                            <li class="py-3 sm:py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-10 h-10 text-gray-500 dark:text-gray-400">
                                            <path fill-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7 9.75c0-.41.34-.75.75-.75h8.5c.41 0 .75.34.75.75s-.34.75-.75.75h-8.5c-.41 0-.75-.34-.75-.75zm0 4c0-.41.34-.75.75-.75h5.5c.41 0 .75.34.75.75s-.34.75-.75.75h-5.5c-.41 0-.75-.34-.75-.75zm4 4c0-.41.34-.75.75-.75h4.5c.41 0 .75.34.75.75s-.34.75-.75.75h-4.5c-.41 0-.75-.34-.75-.75z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-white truncate dark:text-white">
                                            {{ $comment->user->name }}
                                        </p>
                                        <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                            {{ $comment->content }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </main>
        <footer class="py-16 text-center text-sm text-white dark:text-white/70">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>

    <style>
        /* Contenedor de calificación y comentarios */
        .rating-comments-container {
            background-color: #2d3748; /* Fondo claro */
            width: 100%;
        }

        .rating-comments-container .rating {
            display: flex;
            gap: 0.25rem;
        }

        /* Estilos para las estrellas */
        .star-icon {
            color: #d1d5db; /* Color gris de estrella */
            transition: color 0.2s ease; /* Transición suave para el color */
        }

        .rating input:checked ~ label .star-icon {
            color: #f59e0b; /* Color amarillo para las estrellas seleccionadas */
        }

        .rating label:hover ~ label .star-icon {
            color: #fbbf24; /* Color amarillo más claro al pasar el ratón */
        }

        /* Estilo de los botones */
        .btn-primary {
            background-color: #3b82f6; /* Color de fondo azul */
            color: white; /* Color del texto */
            padding: 0.5rem 1rem; /* Espaciado del botón */
            border-radius: 0.375rem; /* Bordes redondeados */
            transition: background-color 0.2s ease; /* Transición suave para el color de fondo */
        }

        .btn-primary:hover {
            background-color: #2563eb; /* Color de fondo al pasar el ratón */
        }

        /* Estilos para el formulario de comentario */
        .form-control {
            border: 1px solid #2d3748; /* Borde gris claro */
        }

        /* Estilos para el formulario de comentario en modo oscuro */
        .dark .form-control {
            background-color: #1f2937; /* Fondo oscuro */
            border-color: #4b5563; /* Borde gris oscuro */
        }

        /* Estilo para el área de comentarios */
        .comments-list .comment {
            background-color: #2d3748; /* Fondo blanco */
            border: 1px solid #e5e7eb; /* Borde gris claro */
            color: #374151; /* Texto gris oscuro */
        }

        .dark .comments-list .comment {
            background-color: #111827; /* Fondo oscuro */
            border-color: #4b5563; /* Borde gris oscuro */
            color: #d1d5db; /* Texto gris claro */
        }

        /* Estilos para el header fijo */
        header {
            background-color: #1f2937; /* Color de fondo */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }
    </style>
</body>

</html>
