@extends('layouts.app')

@section('title', 'Nueva Factura')

@section('content')
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow-lg mt-6">
        <h2 class="text-2xl font-bold text-center text-cyan-600 mb-6">🧾 {{ __('Nueva Factura') }}</h2>

        <form action="{{ route('facturas.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <!-- Cliente -->
            <div>
                <x-input-label for="cliente_id" :value="__('Cliente')" />
                <select id="cliente_id" name="cliente_id" class="block w-full p-3 border border-cyan-300 rounded-md focus:ring-2 focus:ring-cyan-500" required>
                    <option value="">{{ __('Selecciona un Cliente') }}</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('cliente_id')" class="mt-2" />
            </div>

            <!-- Número de Factura -->
            <div>
                <x-input-label for="numero_factura" :value="__('Número de Factura')" />
                <x-text-input id="numero_factura" class="block w-full p-3 border border-cyan-300 rounded-md focus:ring-2 focus:ring-cyan-500"
                              type="text" name="numero_factura" value="{{ old('numero_factura') }}" required />
                <x-input-error :messages="$errors->get('numero_factura')" class="mt-2" />
            </div>

            <!-- Monto Total -->
            <div>
                <x-input-label for="monto_total" :value="__('Monto Total')" />
                <x-text-input id="monto_total" class="block w-full p-3 border border-cyan-300 rounded-md focus:ring-2 focus:ring-cyan-500"
                              type="number" step="0.01" name="monto_total" value="{{ old('monto_total') }}" required />
                <x-input-error :messages="$errors->get('monto_total')" class="mt-2" />
            </div>

            <!-- Estado -->
            <div>
                <x-input-label for="estado" :value="__('Estado')" />
                <select id="estado" name="estado" class="block w-full p-3 border border-cyan-300 rounded-md focus:ring-2 focus:ring-cyan-500" required>
                    <option value="pendiente" {{ old('estado') == 'pendiente' ? 'selected' : '' }}>{{ __('Pendiente') }}</option>
                    <option value="pagado" {{ old('estado') == 'pagado' ? 'selected' : '' }}>{{ __('Pagado') }}</option>
                    <option value="vencido" {{ old('estado') == 'vencido' ? 'selected' : '' }}>{{ __('Vencido') }}</option>
                </select>
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>

            <!-- Botones -->
            <div class="flex justify-between mt-6">
                <a href="{{ route('facturas.index') }}" class="bg-gray-500 text-white py-2 px-4 rounded-md hover:bg-gray-600 focus:ring-2 focus:ring-gray-400">
                    ⬅️ {{ __('Cancelar') }}
                </a>
                <x-primary-button class="bg-cyan-600 text-white py-2 px-4 rounded-md hover:bg-cyan-700 focus:ring-2 focus:ring-cyan-500">
                    💾 {{ __('Guardar Factura') }}
                </x-primary-button>
            </div>
        </form>
    </div>
@endsection
