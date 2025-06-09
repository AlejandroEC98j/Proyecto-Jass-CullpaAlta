@extends('layouts.app')

@section('title', 'Lista de Facturas')

@section('content')
    <div class="max-w-6xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <!-- Encabezado con botón de volver -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-cyan-600">{{ __('Facturas Registradas') }}</h2>
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
            <form action="{{ route('facturas.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Buscador por cliente -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Buscar Cliente</label>
                    <input type="text" name="search" id="search" 
                           placeholder="Nombre del cliente"
                           value="{{ request('search') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>

                <!-- Filtro por estado -->
                <div>
                    <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="estado" id="estado" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                        <option value="">Todos los estados</option>
                        <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ request('estado') == 'pagado' ? 'selected' : '' }}>Pagado</option>
                        <option value="vencido" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                    </select>
                </div>

                <!-- Filtro por rango de fechas -->
                <div>
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">Fecha Desde</label>
                    <input type="date" name="fecha_inicio" id="fecha_inicio" 
                           value="{{ request('fecha_inicio') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>
                <div>
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700 mb-1">Fecha Hasta</label>
                    <input type="date" name="fecha_fin" id="fecha_fin" 
                           value="{{ request('fecha_fin') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-cyan-500">
                </div>

                <!-- Botones -->
                <div class="flex items-end space-x-2 md:col-span-4">
                    <button type="submit" class="bg-cyan-600 text-white font-semibold px-6 py-2 rounded-md shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500 transition">
                        🔍 Buscar
                    </button>
                    @if(request()->has('search') || request()->has('estado') || request()->has('fecha_inicio') || request()->has('fecha_fin'))
                        <a href="{{ route('facturas.index') }}" class="bg-gray-500 text-white font-semibold px-4 py-2 rounded-md shadow-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 transition">
                            Limpiar
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300 rounded-lg shadow-md">
                <thead class="bg-cyan-100 text-gray-700">
                    <tr>
                        <th class="border border-gray-300 px-4 py-3">Número</th>
                        <th class="border border-gray-300 px-4 py-3">Cliente</th>
                        <th class="border border-gray-300 px-4 py-3">Monto</th>
                        <th class="border border-gray-300 px-4 py-3">Estado</th>
                        <th class="border border-gray-300 px-4 py-3">Emisión</th>
                        <th class="border border-gray-300 px-4 py-3">Vencimiento</th>
                        <th class="border border-gray-300 px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($facturas as $factura)
                        <tr class="border border-gray-300 hover:bg-cyan-50 transition">
                            <td class="border px-4 py-3 text-center">{{ $factura->numero_factura }}</td>
                            <td class="border px-4 py-3">{{ $factura->cliente->nombre }}</td>
                            <td class="border px-4 py-3 text-center">S/ {{ number_format($factura->monto_total, 2) }}</td>
                            <td class="border px-4 py-3 text-center">
                                <span class="px-2 py-1 rounded text-white 
                                    {{ $factura->estado == 'pendiente' ? 'bg-blue-500' : '' }}
                                    {{ $factura->estado == 'vencido' ? 'bg-red-500' : '' }}
                                    {{ $factura->estado == 'pagado' ? 'bg-green-500' : '' }}">
                                    {{ ucfirst($factura->estado) }}
                                </span>
                            </td>
                            <td class="border px-4 py-3 text-center">{{ $factura->fecha_emision->format('d/m/Y') }}</td>
                            <td class="border px-4 py-3 text-center">
                                @if($factura->estado !== 'vencido')
                                    {{ $factura->fecha_vencimiento->format('d/m/Y') }}
                                @else
                                    <span class="text-red-500">Vencida</span>
                                @endif
                            </td>
                            <td class="border px-4 py-3 text-center flex justify-center space-x-4">
                                <a href="{{ route('facturas.edit', $factura->id) }}" class="text-cyan-600 font-semibold hover:underline">
                                    ✏️ {{ __('Editar') }}
                                </a>
                                <form action="{{ route('facturas.destroy', $factura->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta factura?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 font-semibold hover:underline">
                                        🗑️ {{ __('Eliminar') }}
                                    </button>
                                </form>
                                @if($factura->estado !== 'pagado')
                                    <a href="{{ route('pagos.create', ['factura_id' => $factura->id]) }}" class="text-green-600 font-semibold hover:underline">
                                        💳 {{ __('Pagar') }}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr class="text-center">
                            <td colspan="7" class="py-4 text-gray-500">
                                @if(request()->has('search') || request()->has('estado') || request()->has('fecha_inicio') || request()->has('fecha_fin'))
                                    {{ __('No se encontraron facturas con los filtros aplicados') }}
                                @else
                                    {{ __('No hay facturas registradas') }}
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Paginación -->
        @if($facturas->hasPages())
            <div class="mt-4">
                {{ $facturas->appends(request()->query())->links() }}
            </div>
        @endif

        <!-- Botón para agregar nueva factura -->
        <div class="mt-8 flex justify-center">
            <a href="{{ route('facturas.create') }}" class="bg-cyan-600 text-white font-semibold px-6 py-3 rounded-md shadow-md hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-cyan-500">
                ➕ {{ __('Agregar Factura') }}
            </a>
        </div>
    </div>
@endsection