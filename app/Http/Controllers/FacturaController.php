<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FacturaController extends Controller
{
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
    
        // 🔹 Aquí creamos la factura antes del `if`
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
            'cliente_id' => 'required|exists:clientes,id', // Validar que el cliente exista
            'numero_factura' => 'required|unique:facturas,numero_factura,' . $factura->id, // Validar que el número de factura sea único excepto en esta factura
            'monto_total' => 'required|numeric', // Validar monto
            'estado' => 'required|in:pendiente,pagado,vencido', // Validar estado
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

    // Método para listar todas las facturas
    public function index()
    {
        // Obtener todas las facturas
        $facturas = Factura::all();

        // Revisar si alguna factura está vencida y actualizar su estado
        foreach ($facturas as $factura) {
            // Verificar si la factura está vencida y actualizar el estado
            if ($factura->fecha_vencimiento < Carbon::now() && $factura->estado !== 'vencido') {
                $factura->estado = 'vencido';
                $factura->save();
            }
        }

        return view('facturas.index', compact('facturas'));
    }
}
