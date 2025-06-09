<?php

namespace App\Http\Controllers;

use App\Models\Medidor;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedidorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Requiere autenticación
    }

    public function index()
    {
        $medidores = Medidor::with('cliente')->paginate(10);
        return view('medidores.index', compact('medidores'));
    }
    
    public function create()
    {
        $clientes = Cliente::all();
        return view('medidores.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'numero_serie' => 'required|unique:medidores,numero_serie',
            'direccion' => 'required',
            'estado' => 'required|in:Activo,Inactivo,Mantenimiento,Dañado'
        ]);

        try {
            Medidor::create($request->all());
            return redirect()->route('medidores.index')->with('success', 'Medidor agregado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al agregar medidor: ' . $e->getMessage());
            return redirect()->route('medidores.create')->with('error', 'Error al agregar el medidor.');
        }
    }

    public function edit(Medidor $medidor)
    {
        $clientes = Cliente::all();
        return view('medidores.edit', compact('medidor', 'clientes'));
    }

    public function update(Request $request, Medidor $medidor)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'numero_serie' => 'required|unique:medidores,numero_serie',
            'direccion' => 'required',
            'estado' => 'required|in:Activo,Inactivo,Mantenimiento,Dañado'
        ]);

        try {
            $medidor->update($request->all());
            return redirect()->route('medidores.index')->with('success', 'Medidor actualizado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al actualizar medidor: ' . $e->getMessage());
            return redirect()->route('medidores.edit', $medidor)->with('error', 'Error al actualizar el medidor.');
        }
    }

    public function destroy(Medidor $medidor)
    {
        try {
            $medidor->delete();
            return redirect()->route('medidores.index')->with('success', 'Medidor eliminado correctamente.');
        } catch (\Exception $e) {
            Log::error('Error al eliminar medidor: ' . $e->getMessage());
            return redirect()->route('medidores.index')->with('error', 'Error al eliminar el medidor.');
        }
    }
}
