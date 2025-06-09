<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Estilos (Si usas Vite, incluye estos) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Fuentes de Google para mejor tipografía -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Barra de navegación mejorada -->
        @include('layouts.navigation')

        <!-- Contenido de la página con más márgenes y mejor espaciado -->
        <main class="flex-grow container mx-auto px-4 py-8 md:px-6 lg:px-8">
            <!-- Añadido un contenedor con sombra y fondo blanco para el contenido principal -->
            <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
                @yield('content')  <!-- Aquí cargará el contenido de cada vista -->
            </div>
        </main>
        
        <!-- Footer opcional (puedes descomentar si lo necesitas) -->
        <!--
        <footer class="bg-gray-800 text-white py-6">
            <div class="container mx-auto px-4 text-center">
                <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.</p>
            </div>
        </footer>
        -->
    </div>
</body>
</html>