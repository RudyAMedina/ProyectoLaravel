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
                                    <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24px" height="24px">
                                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                      </svg>
                                     {{ Auth::user()->name }}</div>
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
                    
                        <h1 class="text-3xl font-bold mb-4">{{ $pelicula->title }}</h1>
                        <h3>Calificacion: {{ number_format($pelicula->averageRating(), 2) }}</h3>
                        <iframe src="{{ $pelicula->slug }}" sandbox="allow-same-origin allow-scripts" width=80% height="600px" scrolling="no" frameborder="0" allowfullscreen="true"></iframe>

                        <h3>Calificacion pelicula <h3>
                        <form action="{{ route('rate') }}" method="POST">
                            @csrf
                            <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">

                            <div class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}">
                                    <label for="star{{ $i }}">{{ $i }} estrella</label>
                                @endfor
                            </div>
                            <button type="submit" class="btn btn-primary">Calificar</button>
                        </form>
                  
                <div>
                    <h3>Agregar comentario:</h3>
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="peliculas_id" value="{{ $pelicula->id }}">
                        <div class="form-group">
                            <textarea name="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Enviar comentario</button>
                    </form>
                </div>
                
                <div>
                    <h3>Commentarios:</h3>
                    
                        @foreach($pelicula->comments as $comment)
                            <div class="comment">
                                <p><strong>{{ $comment->user->name }}:</strong></p>
                                <p>{{ $comment->content }}</p>
                            </div>
                        @endforeach
                    
                </div>
            </main>                 
        </div>
                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                </footer>
                
    </body>
</html>
