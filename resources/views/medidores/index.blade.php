@extends('layouts.app')

@section('title', 'Lista de Medidores')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Encabezado con botón de volver -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-cyan-600">{{ __('Medidores Registrados') }}</h2>
            <a href="{{ route('dashboard') }}" class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-md shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                ← Volver al Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-500 text-white p-3 rounded-md mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabla de medidores -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-cyan-100 text-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-4 py-3">ID</th>
                        <th class="border border-gray-300 px-4 py-3">Número de Serie</th>
                        <th class="border border-gray-300 px-4 py-3">Cliente</th>
                        <th class="border border-gray-300 px-4 py-3">Estado</th>
                        <th class="border border-gray-300 px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($medidores as $medidor)
                        <tr class="border border-gray-300 hover:bg-cyan-50 transition">
                            <td class="border px-4 py-3 text-center">{{ $medidor->id }}</td>
                            <td class="border px-4 py-3 text-center">{{ $medidor->numero_serie }}</td>
                            <td class="border px-4 py-3">{{ $medidor->cliente->nombre ?? 'No asignado' }}</td>
                            <td class="border px-4 py-3 text-center">
                                <span class="px-2 py-1 text-xs font-semibold rounded-full 
                                    {{ $medidor->estado == 'Activo' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $medidor->estado == 'Inactivo' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $medidor->estado == 'Mantenimiento' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $medidor->estado == 'Dañado' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $medidor->estado }}
                                </span>
                            </td>
                            <td class="border px-4 py-3 text-center flex justify-center space-x-4">
                                <a href="{{ route('medidores.edit', $medidor->id) }}" class="text-cyan-600 font-semibold hover:underline">
                                    ✏️ {{ __('Editar') }}
                                </a>
                                <form action="{{ route('medidores.destroy', $medidor->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este medidor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">
                                        🗑️ {{ __('Eliminar') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="5" class="py-4 text-gray-500">{{ __('No hay medidores registrados') }}</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Botón para agregar nuevo medidor (mismo estilo que en clientes) -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('medidores.create') }}" class="bg-cyan-600 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                ➕ {{ __('Agregar Medidor') }}
            </a>
        </div>
    </div>
@endsection