@extends('layouts.app')

@section('title', 'Bienvenido')

@section('content')
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <div class="bg-white p-10 rounded-lg shadow-lg text-center">
            <h1 class="text-4xl font-bold text-blue-600 mb-4">Bienvenido a JASS UNAS</h1>
            <p class="text-lg text-gray-700">Sistema de Gestión de Agua Potable y Saneamiento</p>
            <p class="text-md text-gray-600 mt-2">Optimiza la administración de clientes, medidores y facturas de manera eficiente.</p>
            <div class="mt-6">
                @auth
                    <p>Bienvenido, {{ Auth::user()->name }}!</p>
                @else
                    <p>Bienvenido, invitado!</p>
                @endauth

            </div>
        </div>
    </div>
@endsection
