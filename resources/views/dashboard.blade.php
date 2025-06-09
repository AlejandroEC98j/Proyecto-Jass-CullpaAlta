@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        :root {
            --primary-color: #0891b2; /* cyan-600 */
            --primary-light: #ecfeff; /* cyan-50 */
            --primary-dark: #0e7490; /* cyan-700 */
            --secondary-color: #4f46e5; /* indigo-600 */
            --success-color: #16a34a; /* green-600 */
            --warning-color: #d97706; /* amber-600 */
            --danger-color: #dc2626; /* red-600 */
        }

        .dashboard-container {
            max-width: 7xl;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Estilo para los botones de navegación */
        .nav-btn-original {
            display: inline-flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            margin: 0.5rem;
            border-radius: 0.375rem;
            font-weight: 500;
            text-transform: uppercase;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .nav-btn-original:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Estilo para las tarjetas de contadores */
        .counter-card {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin: 1rem;
            text-align: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s ease;
            width: 250px;
        }

        .counter-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .counter-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }

        .counter-value {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 0.5rem 0;
        }

        .counter-label {
            color: #64748b;
            font-size: 1rem;
        }

        /* Estilos para los filtros */
        .filter-controls {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin: 1.5rem 0;
        }

        .filter-select {
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: 1px solid #e2e8f0;
        }

        .filter-btn {
            padding: 0.5rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border-radius: 0.375rem;
            transition: all 0.2s ease;
        }

        .filter-btn:hover {
            background-color: var(--primary-dark);
        }

        /* Estilo para los gráficos */
        .chart-container {
            background: white;
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin: 1.5rem 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .chart-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 1rem;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-wrapper {
            height: 300px;
            position: relative;
        }

        /* Estilo para el mensaje informativo */
        .info-message {
            background: rgba(8, 145, 178, 0.05);
            padding: 1.5rem;
            border-radius: 0.5rem;
            border-left: 4px solid var(--primary-color);
            margin-top: 2rem;
        }

        .info-message-title {
            font-weight: 600;
            color: var(--primary-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .info-message-text {
            color: #64748b;
        }
    </style>

    <div class="dashboard-container">
        <!-- Header Section -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">
                JUNTA ADMINISTRADORA DE SERVICIOS DE SANEAMIENTO
            </h1>
            <p class="text-xl text-gray-600">Chambara - Concepción</p>
        </div>

        <!-- Filter Controls -->
        <form id="filterForm" method="GET" action="{{ route('dashboard') }}" class="filter-controls">
            @csrf
            <select name="year" id="yearFilter" class="filter-select">
                <option value="">Seleccionar año</option>
                @foreach(range(date('Y'), date('Y') - 5, -1) as $year)
                    <option value="{{ $year }}" {{ $filterYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endforeach
            </select>
            
            <select name="month" id="monthFilter" class="filter-select">
                <option value="">Seleccionar mes</option>
                @foreach([
                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril', 
                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                ] as $num => $name)
                    <option value="{{ $num }}" {{ $filterMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
            
            <button type="submit" class="filter-btn">
                <i class="fas fa-filter mr-2"></i> Filtrar
            </button>
            
            @if($filterApplied)
                <a href="{{ route('dashboard') }}" class="filter-btn bg-gray-500 hover:bg-gray-600">
                    <i class="fas fa-times mr-2"></i> Limpiar
                </a>
            @endif
        </form>

        <!-- Stats Cards -->
        <div class="flex flex-wrap justify-center">
            <!-- Clientes Card -->
            <div class="counter-card">
                <div class="counter-icon">
                    <i class="fas fa-users"></i>
                </div>
                <div class="counter-value text-cyan-600">{{ $totalClientes }}</div>
                <div class="counter-label">Clientes Registrados</div>
                @if($filterApplied)
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $filterMonth ? 'En ' . \Carbon\Carbon::create()->month($filterMonth)->monthName : '' }}
                        {{ $filterYear ? ' ' . $filterYear : '' }}
                    </div>
                @endif
            </div>
            
            <!-- Medidores Card -->
            <div class="counter-card">
                <div class="counter-icon">
                    <i class="fas fa-tachometer-alt"></i>
                </div>
                <div class="counter-value text-green-600">{{ $totalMedidores }}</div>
                <div class="counter-label">Medidores Activos</div>
                @if($filterApplied)
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $filterMonth ? 'En ' . \Carbon\Carbon::create()->month($filterMonth)->monthName : '' }}
                        {{ $filterYear ? ' ' . $filterYear : '' }}
                    </div>
                @endif
            </div>
            
            <!-- Facturas Card -->
            <div class="counter-card">
                <div class="counter-icon">
                    <i class="fas fa-file-invoice-dollar"></i>
                </div>
                <div class="counter-value text-red-600">{{ $totalFacturas }}</div>
                <div class="counter-label">Facturas Emitidas</div>
                @if($filterApplied)
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $filterMonth ? 'En ' . \Carbon\Carbon::create()->month($filterMonth)->monthName : '' }}
                        {{ $filterYear ? ' ' . $filterYear : '' }}
                    </div>
                @endif
            </div>
            
            <!-- Pagos Card -->
            <div class="counter-card">
                <div class="counter-icon">
                    <i class="fas fa-credit-card"></i>
                </div>
                <div class="counter-value text-purple-600">{{ $totalPagos }}</div>
                <div class="counter-label">Pagos Registrados</div>
                @if($filterApplied)
                    <div class="text-xs text-gray-500 mt-2">
                        {{ $filterMonth ? 'En ' . \Carbon\Carbon::create()->month($filterMonth)->monthName : '' }}
                        {{ $filterYear ? ' ' . $filterYear : '' }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Gráficos Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
            <!-- Consumo Chart -->
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-bar mr-2"></i> Consumo Promedio (m³)
                </h3>
                <div class="chart-wrapper">
                    <canvas id="consumptionChart"></canvas>
                </div>
            </div>
            
            <!-- Pagos Chart -->
            <div class="chart-container">
                <h3 class="chart-title">
                    <i class="fas fa-chart-pie mr-2"></i> Estado de Pagos
                </h3>
                <div class="chart-wrapper">
                    <canvas id="paymentsChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Navigation Buttons -->
        <div class="text-center mt-8">
            <a href="{{ route('clientes.index') }}" class="nav-btn-original bg-cyan-600 text-white hover:bg-cyan-700">
                <i class="fas fa-users mr-2"></i> Clientes
            </a>
            <a href="{{ route('medidores.index') }}" class="nav-btn-original bg-green-600 text-white hover:bg-green-700">
                <i class="fas fa-tachometer-alt mr-2"></i> Medidores
            </a>
            <a href="{{ route('facturas.index') }}" class="nav-btn-original bg-red-600 text-white hover:bg-red-700">
                <i class="fas fa-file-invoice-dollar mr-2"></i> Facturas
            </a>
            <a href="{{ route('pagos.index') }}" class="nav-btn-original bg-purple-600 text-white hover:bg-purple-700">
                <i class="fas fa-credit-card mr-2"></i> Pagos
            </a>
        </div>

        <!-- Info Message -->
        <div class="info-message">
            <h4 class="info-message-title">
                <i class="fas fa-tint"></i> Cuidemos el agua. ¡Cada gota cuenta!
            </h4>
            <p class="info-message-text">
                JASS Chambara - Proveedor de agua y servicios de saneamiento para nuestra comunidad.
                Reporte cualquier fuga o anomalía en el suministro.
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datos para los gráficos
            const consumptionData = {
                labels: @json($meses),
                data: @json($pagosPorMes)
            };
            
            const paymentStatusData = {
                labels: ['Pagadas', 'Pendientes', 'Vencidas'],
                data: [
                    {{ $paymentStatusData['data'][0] ?? 70 }},
                    {{ $paymentStatusData['data'][1] ?? 20 }}, 
                    {{ $paymentStatusData['data'][2] ?? 10 }}
                ]
            };

            // Consumption Chart
            const consumptionCtx = document.getElementById('consumptionChart')?.getContext('2d');
            if (consumptionCtx) {
                new Chart(consumptionCtx, {
                    type: 'bar',
                    data: {
                        labels: consumptionData.labels,
                        datasets: [{
                            label: 'Consumo (m³)',
                            data: consumptionData.data,
                            backgroundColor: 'rgba(8, 145, 178, 0.7)',
                            borderColor: 'rgba(8, 145, 178, 1)',
                            borderWidth: 1,
                            borderRadius: 4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.parsed.y} m³`;
                                    }
                                }
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Metros Cúbicos (m³)'
                                }
                            }
                        }
                    }
                });
            }

            // Payments Chart
            const paymentsCtx = document.getElementById('paymentsChart')?.getContext('2d');
            if (paymentsCtx) {
                new Chart(paymentsCtx, {
                    type: 'doughnut',
                    data: {
                        labels: paymentStatusData.labels,
                        datasets: [{
                            data: paymentStatusData.data,
                            backgroundColor: [
                                'rgba(22, 163, 74, 0.7)',
                                'rgba(234, 179, 8, 0.7)',
                                'rgba(220, 38, 38, 0.7)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return ` ${context.parsed}%`;
                                    }
                                }
                            }
                        },
                        cutout: '70%'
                    }
                });
            }
        });
    </script>
@endsection