@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-2xl font-bold text-center mb-6 text-cyan-600">Agregar Nuevo Medidor</h2>

    {{-- Mensaje de error general --}}
    @if(session('error'))
        <div class="bg-red-500 text-white p-3 rounded-md mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulario de creación --}}
    <form action="{{ route('medidores.store') }}" method="POST">
        @csrf

        {{-- Cliente (Opcional) --}}
        <div class="mb-4">
            <label for="cliente_id" class="block text-gray-700 font-semibold">Cliente (Opcional)</label>
            <select name="cliente_id" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="">-- Seleccionar Cliente --</option>
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                        {{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
            @error('cliente_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Número de Serie --}}
        <div class="mb-4">
            <label for="numero_serie" class="block text-gray-700 font-semibold">Número de Serie</label>
            <input type="text" name="numero_serie" value="{{ old('numero_serie') }}" class="w-full p-2 border border-gray-300 rounded-md" required>
            @error('numero_serie')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Dirección --}}
        <div class="mb-4">
            <label for="direccion" class="block text-gray-700 font-semibold">Dirección</label>
            <input type="text" name="direccion" value="{{ old('direccion') }}" class="w-full p-2 border border-gray-300 rounded-md" required>
            @error('direccion')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Estado --}}
        <div class="mb-4">
            <label for="estado" class="block text-gray-700 font-semibold">Estado</label>
            <select name="estado" class="w-full p-2 border border-gray-300 rounded-md">
                <option value="Activo" {{ old('estado') == 'Activo' ? 'selected' : '' }}>Activo</option>
                <option value="Inactivo" {{ old('estado') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                <option value="Mantenimiento" {{ old('estado') == 'Mantenimiento' ? 'selected' : '' }}>Mantenimiento</option>
                <option value="Dañado" {{ old('estado') == 'Dañado' ? 'selected' : '' }}>Dañado</option>
            </select>
            @error('estado')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="flex justify-between">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md hover:bg-green-700">
                ✅ Guardar
            </button>
            <a href="{{ route('medidores.index') }}" class="bg-gray-500 text-white px-6 py-2 rounded-md hover:bg-gray-600">
                ⬅️ Volver
            </a>
        </div>
    </form>
</div>
@endsection
