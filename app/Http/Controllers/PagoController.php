<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Importar DomPDF


class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('factura')->get();
        return view('pagos.index', compact('pagos'));
    }

    public function create($factura_id)
    {
        $factura = Factura::findOrFail($factura_id);// Obtener la factura específica
        return view('pagos.create', compact('factura'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'factura_id' => 'required|exists:facturas,id',
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);
    
        // Registrar el pago
        $pago = Pago::create($request->all());
    
        // Marcar la factura como pagada
        $factura = Factura::findOrFail($request->factura_id);
        $factura->estado = 'pagado';
        $factura->save();
    
        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }
    

    public function update(Request $request, $id)
    {
        $request->validate([
            'monto_pagado' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
        ]);

        $pago = Pago::findOrFail($id);
        $pago->update($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }

    public function generarPDF($id)
    {
        $pago = Pago::with('factura.cliente')->findOrFail($id);

        $pdf = Pdf::loadView('pagos.pdf', compact('pago'));

        return $pdf->download('comprobante_pago.pdf');
    }
}
