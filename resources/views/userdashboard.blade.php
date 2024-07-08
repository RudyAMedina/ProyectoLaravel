<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bienvenido') }}
        </h2>
    </x-slot>
    @if(Auth::check() && Auth::user()->hasRole('admin'))
    <p>Estás viendo esto como administrador.</p>
@else
    <p>No tienes permisos de administrador para ver esto.</p>
@endif
</x-app-layout>