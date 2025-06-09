@extends('layouts.app')

@section('title', 'Editar Medidor')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-md border border-gray-100">
    <!-- Header with decorative elements -->
    <div class="text-center mb-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-2">Editar Medidor</h2>
        <div class="w-24 h-1 bg-gradient-to-r from-cyan-400 to-teal-400 mx-auto"></div>
        <p class="text-gray-600 mt-4">Sistema de Gestión JASS Chambara</p>
    </div>

    <form action="{{ route('medidores.update', $medidor->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <!-- Client Selection -->
        <div class="space-y-2">
            <x-input-label for="cliente_id" value="Cliente (Opcional)" class="text-gray-700 font-medium" />
            <select id="cliente_id" name="cliente_id" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent transition">
                <option value="">-- Seleccionar Cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $medidor->cliente_id) == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('cliente_id')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Dynamic Fields -->
        @foreach ([
            'numero_serie' => 'Número de Serie',
            'monto_a_pagar' => 'Monto a Pagar',
            'direccion' => 'Dirección'
        ] as $field => $label)
            <div class="space-y-2">
                <x-input-label for="{{ $field }}" :value="$label" class="text-gray-700 font-medium" />
                <x-text-input id="{{ $field }}" 
                    class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent transition"
                    type="{{ $field === 'monto_a_pagar' ? 'number' : 'text' }}" 
                    name="{{ $field }}" 
                    value="{{ old($field, $medidor->$field) }}" 
                    required
                    {{ $field === 'monto_a_pagar' ? 'step="0.01" min="0"' : '' }} />
                <x-input-error :messages="$errors->get($field)" class="mt-1 text-sm text-red-600" />
            </div>
        @endforeach

        <!-- Status -->
        <div class="space-y-2">
            <x-input-label for="estado" value="Estado" class="text-gray-700 font-medium" />
            <select id="estado" name="estado" class="block w-full px-4 py-3 border border-gray-200 rounded-lg focus:ring-2 focus:ring-cyan-300 focus:border-transparent transition" required>
                @foreach(['Activo', 'Inactivo', 'Mantenimiento', 'Dañado'] as $status)
                    <option value="{{ $status }}" {{ old('estado', $medidor->estado) == $status ? 'selected' : '' }}>
                        {{ $status }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('estado')" class="mt-1 text-sm text-red-600" />
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-between pt-6 border-t border-gray-100">
            <a href="{{ route('medidores.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition duration-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Cancelar
            </a>
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-cyan-500 to-teal-500 hover:from-cyan-600 hover:to-teal-600 text-white rounded-lg shadow-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-cyan-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection