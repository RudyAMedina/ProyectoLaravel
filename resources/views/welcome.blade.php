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
            <!-- Logo a la izquierda -->
            <div class="flex items-center">
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

        <main class="mt-24 container mx-auto px-4 pb-16"> <!-- Aumentar el margen superior y añadir padding inferior -->
            @if(request()->filled('search'))
            <div class="mb-8">
                <h2 class="text-2xl font-bold mb-4 text-white">Resultados de la búsqueda</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                    @foreach ($peliculas as $pelicula)
                    <div class="w-48 flex-shrink-0 rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800">
                        <a href="{{ route('peliculas.show', $pelicula->id) }}" class="block">
                            @if($pelicula->image)
                            <img src="{{ asset('images/' . $pelicula->image) }}" alt="{{ $pelicula->title }}" class="w-full h-64 object-cover">
                            @endif
                            <div class="p-4">
                                <h2 class="text-lg font-semibold text-white">{{ $pelicula->title }}</h2>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
            @else
            <div class="container mx-auto py-8">
                @foreach ($categories as $category)
                @if ($category->peliculas->count() > 0)
                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-white mb-4">{{ $category->titulo }}</h2>
                    <div class="relative group carousel-container">
                        <!-- Botón anterior -->
                        <button class="absolute left-0 top-1/2 transform -translate-y-3/4 bg-gray-800 text-white p-2 rounded-full carousel-prev hidden">‹</button>
                        <div class="flex overflow-x-scroll space-x-8 p-4 scrollbar-hide carousel-container bg-gray-900 dark:bg-gray-700 rounded-lg">
                            @foreach ($category->peliculas as $pelicula)
                            @if ($loop->index < 5) 
                            <div class="w-48 flex-shrink-0 rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-800">
                                <a href="{{ route('peliculas.show', $pelicula->id) }}" class="block">
                                    @if($pelicula->image)
                                    <img src="{{ asset('images/' . $pelicula->image) }}" alt="{{ $pelicula->title }}" class="w-full h-64 object-cover">
                                    @endif
                                    <div class="p-4">
                                        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ $pelicula->title }}</h2>
                                    </div>
                                </a>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        <!-- Botón siguiente -->
                        <button class="absolute right-0 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full carousel-next hidden">›</button>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </main>

        <footer class="py-16 text-center text-sm bg-gray-800 text-white">
            Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
        </footer>
    </div>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const prevButtons = document.querySelectorAll('.carousel-prev');
        const nextButtons = document.querySelectorAll('.carousel-next');

        prevButtons.forEach(button => {
            button.addEventListener('click', function() {
                const container = button.nextElementSibling;
                container.scrollBy({
                    left: -container.offsetWidth,
                    behavior: 'smooth'
                });
            });
        });

        nextButtons.forEach(button => {
            button.addEventListener('click', function() {
                const container = button.previousElementSibling;
                container.scrollBy({
                    left: container.offsetWidth,
                    behavior: 'smooth'
                });
            });
        });

        // Mostrar botones de navegación si es necesario
        const containers = document.querySelectorAll('.carousel-container');
        containers.forEach(container => {
            if (container.scrollWidth > container.clientWidth) {
                container.parentElement.querySelector('.carousel-prev').classList.remove('hidden');
                container.parentElement.querySelector('.carousel-next').classList.remove('hidden');
            }
        });
    });
    </script>
</body>

</html>
