<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cliente;
use App\Models\Medidor;
use App\Models\Factura;
use App\Models\Pago;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Obtener parámetros de filtro
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));
        $filterApplied = $request->has('year') || $request->has('month');

        // Obtener facturas vencidas (filtradas si aplica)
        $facturasVencidasQuery = Factura::where('estado', 'vencido');
        if ($filterApplied) {
            $facturasVencidasQuery->whereYear('fecha_vencimiento', $year)
                                 ->whereMonth('fecha_vencimiento', $month);
        }
        $facturasVencidas = $facturasVencidasQuery->get();

        // Obtener estadísticas (manteniendo tus nombres de variables originales)
        $totalClientes = $this->getFilteredCount(new Cliente(), $year, $month);
        $totalMedidores = $this->getFilteredCount(new Medidor(), $year, $month);
        $totalFacturas = $this->getFilteredCount(new Factura(), $year, $month, 'fecha_emision');
        $totalPagos = $this->getFilteredCount(new Pago(), $year, $month, 'fecha_pago');

        // Datos para gráficos
        $chartData = $this->getChartData($year, $month);

        return view('dashboard', [
            // Manteniendo tus variables originales
            'totalClientes' => $totalClientes,
            'totalMedidores' => $totalMedidores,
            'totalFacturas' => $totalFacturas,
            'totalPagos' => $totalPagos,
            'facturasVencidas' => $facturasVencidas,
            'meses' => $chartData['meses'],
            'pagosPorMes' => $chartData['pagosPorMes'],
            
            // Nuevas variables para gráficos
            'consumptionData' => $chartData['consumptionData'],
            'paymentStatusData' => $chartData['paymentStatusData'],
            
            // Variables para filtros
            'filterYear' => $year,
            'filterMonth' => $month,
            'filterApplied' => $filterApplied,
        ]);
    }

    protected function getFilteredCount($model, $year = null, $month = null, $dateField = 'created_at')
    {
        $query = $model->newQuery();
        
        if ($year) {
            $query->whereYear($dateField, $year);
        }
        
        if ($month) {
            $query->whereMonth($dateField, $month);
        }
        
        return $query->count();
    }

    protected function getChartData($year = null, $month = null)
    {
        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 
                 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        $pagosPorMes = [];
        foreach (range(1, 12) as $monthNum) {
            $query = Pago::query();
            if ($year) {
                $query->whereYear('fecha_pago', $year);
            }
            $pagosPorMes[] = $query->whereMonth('fecha_pago', $monthNum)->count();
        }

        return [
            'meses' => $meses,
            'pagosPorMes' => $pagosPorMes,
            'consumptionData' => [
                'labels' => $meses,
                'data' => [35, 42, 38, 45, 50, 48, 52, 55, 48, 42, 38, 35] // Datos de ejemplo
            ],
            'paymentStatusData' => [
                'labels' => ['Pagadas', 'Pendientes', 'Vencidas'],
                'data' => [70, 20, 10] // Datos de ejemplo
            ]
        ];
    }
}