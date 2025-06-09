<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $estado = $request->input('estado');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $query = Factura::with('cliente')
            ->when($search, function($query) use ($search) {
                return $query->whereHas('cliente', function($q) use ($search) {
                    $q->where('nombre', 'like', "%$search%");
                });
            })
            ->when($estado, function($query) use ($estado) {
                return $query->where('estado', $estado);
            })
            ->when($fecha_inicio && $fecha_fin, function($query) use ($fecha_inicio, $fecha_fin) {
                return $query->whereBetween('fecha_emision', [
                    Carbon::parse($fecha_inicio)->startOfDay(),
                    Carbon::parse($fecha_fin)->endOfDay()
                ]);
            })
            ->orderBy('fecha_emision', 'desc');

        // Verificar facturas vencidas
        $facturas = $query->get();
        foreach ($facturas as $factura) {
            if ($factura->fecha_vencimiento < Carbon::now() && $factura->estado !== 'vencido') {
                $factura->estado = 'vencido';
                $factura->save();
            }
        }

        // Volver a ejecutar la consulta con paginación
        $facturas = $query->paginate(10);

        return view('facturas.index', compact('facturas'));
    }

    // Método para mostrar el formulario de creación de factura
    public function create()
    {
        // Obtener todos los clientes para el formulario
        $clientes = Cliente::all();
        return view('facturas.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero_factura' => 'required|unique:facturas,numero_factura',
            'monto_total' => 'required|numeric',
            'estado' => 'required|in:pendiente,pagado,vencido',
        ]);
    
        $validated['fecha_emision'] = now();
        $validated['fecha_vencimiento'] = now()->addDays(45);
    
        $factura = Factura::create($validated);
    
        if ($request->expectsJson()) {
            return response()->json(['factura' => $factura], 201);
        }
    
        return redirect()->route('facturas.index')->with('success', 'Factura creada con éxito');
    }
    
    // Método para editar una factura existente
    public function edit(Factura $factura)
    {
        // Obtener los clientes para el formulario de edición
        $clientes = Cliente::all();
        return view('facturas.edit', compact('factura', 'clientes'));
    }

    // Método para actualizar una factura existente
    public function update(Request $request, Factura $factura)
    {
        // Validación de los campos
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'numero_factura' => 'required|unique:facturas,numero_factura,' . $factura->id,
            'monto_total' => 'required|numeric',
            'estado' => 'required|in:pendiente,pagado,vencido',
        ]);

        // Actualizar los datos de la factura
        $factura->update($validated);

        // Redirigir con mensaje de éxito
        return redirect()->route('facturas.index')->with('success', 'Factura actualizada con éxito');
    }

    // Método para eliminar una factura
    public function destroy(Factura $factura)
    {
        $factura->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Factura eliminada con éxito'], 200);
        }

        return redirect()->route('facturas.index')->with('success', 'Factura eliminada con éxito');
    }
}