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
        <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">          
          
                    <header class="grid grid-cols-2 items-center gap-2 py-10 lg:grid-cols-3">
                        <div class="flex lg:justify-center lg:col-start-2">
                            <!-- icono de la pagina -->
                            <a
                                        href="{{ url('/') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="mx-auto h-16">
                            </a>
                        </div>
                        @if (Route::has('login'))
                            <nav class="-mx-3 flex flex-1 justify-end">
                                @auth
                                    <a
                                        href="{{ url('/dashboard') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Dashboard
                                    </a>
                                @else
                                    <a
                                        href="{{ route('login') }}"
                                        class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                    >
                                        Ingresar
                                    </a>

                                    @if (Route::has('register'))
                                        <a
                                            href="{{ route('register') }}"
                                            class="rounded-md px-3 py-2 text-black ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                                        >
                                            Registrarse
                                        </a>
                                    @endif
                                @endauth
                            </nav>
                        @endif
                    </header>

                    <main class="mt-6 container mx-auto px-4">
                        <form action="{{ route('peliculas.lista') }}" method="GET" class="mb-8">
                            <div class="flex justify-center">
                                <input type="text" name="search" placeholder="Buscar por nombre o categoría" class="px-4 py-2 border rounded-l-lg focus:outline-none text-black">
                                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-r-lg">Buscar</button>
                            </div>
                        </form>
                        
                            @if(request()->filled('search'))
                            <div class="mb-8">
                                <h2 class="text-2xl font-bold mb-4">Resultados de la búsqueda</h2>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
                                    @foreach ($peliculas as $pelicula)
                                        <div class="relative bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                                            <a href="{{ route('peliculas.show', $pelicula->id) }}" class="relative bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                                                @if($pelicula->image)
                                                    <img src="{{ asset('images/' . $pelicula->image) }}" alt="{{ $pelicula->title }}" class="w-full h-64 object-cover">
                                                @endif
                                               
                                                    <h2 class="text-lg font-semibold text-white">{{ $pelicula->title }}</h2>
                                                
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                        <div class="mb-8">
                            @foreach ($categories as $category)
                                @if ($category->peliculas->count() > 0)
                                    <div class="mb-8">
                                        <h2 class="text-2xl font-bold mb-4">{{ $category->titulo }}</h2>
                                        <div class="relative px-5">
                                            <!-- Botón anterior -->
                                            <button class="absolute left-0 top-1/2 transform -translate-y-3/4 bg-gray-800 text-white p-2 rounded-full carousel-prev hidden">‹</button>
                                            <div class="flex overflow-x-auto gap-6 pb-4 scrollbar-hide carousel-container">
                                                @foreach ($category->peliculas as $pelicula)
                                                    @if ($loop->index < 5)
                                                        <div class="flex-none w-64">
                                                            <a href="{{ route('peliculas.show', $pelicula->id) }}" class="relative bg-gray-900 rounded-lg overflow-hidden shadow-lg">
                                                                @if($pelicula->image)
                                                                    <img src="{{ asset('images/' . $pelicula->image) }}" alt="{{ $pelicula->title }}" class="w-full h-64 object-cover">
                                                                @endif
                                                                <div class="flex flex-row justify-between absolute inset-x-0 top-3 px-2">
                                                                    <svg class="fill-current stroke-current w-8 h-8 p-2 hover:bg-lime-200 rounded-full" height="100" viewBox="0 0 100 100" width="100" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M15.8,32.9V15.8m0,0H32.9m-17.1,0L37.2,37.2m47-4.3V15.8m0,0H67.1m17.1,0L62.8,37.2m-47,29.9V84.2m0,0H32.9m-17.1,0L37.2,62.8m47,21.4L62.8,62.8M84.2,84.2V67.1m0,17.1H67.1" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8"/>
                                                                    </svg>
                                                                    <svg class="fill-current stroke-current w-8 h-8 p-2 m-1 hover:bg-lime-200 rounded-full" height="100" viewBox="0 0 100 100" width="100" xmlns="http://www.w3.org/2000/svg">
                                                                        <path d="M50,17.4h0M50,50h0m0,32.6h0M50,22a4.7,4.7,0,1,1,4.7-4.6A4.7,4.7,0,0,1,50,22Zm0,32.7A4.7,4.7,0,1,1,54.7,50,4.7,4.7,0,0,1,50,54.7Zm0,32.6a4.7,4.7,0,1,1,4.7-4.7A4.7,4.7,0,0,1,50,87.3Z" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="8"/>
                                                                    </svg>
                                                                </div>
                                                                <div class="absolute bottom-0 bg-gray-50 w-full p-3 flex flex-col gap-1 rounded-b-2xl">
                                                                    <span class="text-lime-400 font-bold text-xs">TAILWIND</span>
                                                                    <span class="text-gray-800 font-bold text-3xl">{{ $pelicula->title }}</span>
                                                                    <p class="text-neutral-800">{{ $pelicula->description }}</p>
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

                    
                </div>
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
    </body>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        const prevButtons = document.querySelectorAll('.carousel-prev');
        const nextButtons = document.querySelectorAll('.carousel-next');

        prevButtons.forEach(button => {
        button.addEventListener('click', function () {
            const container = button.nextElementSibling;
            container.scrollBy({
                left: -container.offsetWidth,
                behavior: 'smooth'
            });
        });
        });

        nextButtons.forEach(button => {
        button.addEventListener('click', function () {
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
</html>
