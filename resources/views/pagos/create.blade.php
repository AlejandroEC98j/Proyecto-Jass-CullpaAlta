@extends('layouts.app')

@section('title', 'Registrar Pago')

@section('content')
    <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6 text-cyan-600">Registrar Pago</h2>

        <form action="{{ route('pagos.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="factura_id" value="{{ $factura->id }}">

            <div>
                <label class="block text-gray-700 font-semibold">Número de Factura:</label>
                <p class="text-gray-900 bg-gray-100 p-2 rounded">{{ $factura->numero_factura }}</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Cliente:</label>
                <p class="text-gray-900 bg-gray-100 p-2 rounded">{{ $factura->cliente->nombre }}</p>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Monto a Pagar:</label>
                <p class="text-gray-900 bg-gray-100 p-2 rounded">{{ number_format($factura->monto_total, 2) }} PEN</p>
                <input type="hidden" name="monto_pagado" value="{{ $factura->monto_total }}">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold">Fecha de Pago:</label>
                <input type="date" name="fecha_pago" value="{{ date('Y-m-d') }}" class="w-full border-gray-300 p-2 rounded">
            </div>

            <div class="flex justify-center">
                <button type="submit" class="bg-cyan-600 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-cyan-700">
                    💰 Pagar
                </button>
            </div>
        </form>
    </div>
@endsection
