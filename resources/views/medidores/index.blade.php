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

        <!-- Buscador y Filtros -->
        <div class="mb-6 bg-cyan-50 p-4 rounded-lg">
            <form action="{{ route('medidores.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Buscador por número de serie o nombre de cliente -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar</label>
                    <input type="text" name="search" id="search" 
                           placeholder="Número de serie o nombre cliente"
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Todos los estados</option>
                        <option value="Activo" {{ request('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ request('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="Mantenimiento" {{ request('estado') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                        <option value="Dañado" {{ request('estado') == 'Dañado' ? 'selected' : '' }}>Dañado</option>
                    </select>
                </div>

                <!-- Botones -->
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-cyan-600 text-white font-semibold px-6 py-2 rounded-md shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition">
                        🔍 Buscar
                    </button>
                    @if(request()->has('search') || request()->has('estado'))
                        <a href="{{ route('medidores.index') }}" class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-md shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

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
                            <td colspan="5" class="py-4 text-gray-500">
                                @if(request()->has('search') || request()->has('estado'))
                                    {{ __('No se encontraron medidores con los filtros aplicados') }}
                                @else
                                    {{ __('No hay medidores registrados') }}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($medidores->hasPages())
            <div class="mt-4">
                {{ $medidores->appends(request()->query())->links() }}
            </div>
        @endif

        <!-- Botón para agregar nuevo medidor -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('medidores.create') }}" class="bg-cyan-600 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                ➕ {{ __('Agregar Medidor') }}
            </a>
        </div>
    </div>
@endsection