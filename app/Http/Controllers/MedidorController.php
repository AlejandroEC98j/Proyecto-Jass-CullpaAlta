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

    public function index(Request $request)
    {
        try {
            $search = $request->input('search');
            $estado = $request->input('estado');

            $medidores = Medidor::with('cliente')
                ->when($search, function($query) use ($search) {
                    return $query->where('numero_serie', 'like', "%$search%")
                        ->orWhereHas('cliente', function($q) use ($search) {
                            $q->where('nombre', 'like', "%$search%");
                        });
                })
                ->when($estado, function($query) use ($estado) {
                    return $query->where('estado', $estado);
                })
                ->orderBy('id', 'desc')
                ->paginate(10);

            return view('medidores.index', compact('medidores'));
        } catch (\Exception $e) {
            Log::error('Error al obtener medidores: ' . $e->getMessage());
            return redirect()->route('medidores.index')->with('error', 'Error al cargar los medidores.');
        }
    }
    
    public function create()
    {
        try {
            $clientes = Cliente::all();
            return view('medidores.create', compact('clientes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de creación: ' . $e->getMessage());
            return redirect()->route('medidores.index')->with('error', 'Error al cargar el formulario.');
        }
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
        try {
            $clientes = Cliente::all();
            return view('medidores.edit', compact('medidor', 'clientes'));
        } catch (\Exception $e) {
            Log::error('Error al cargar formulario de edición: ' . $e->getMessage());
            return redirect()->route('medidores.index')->with('error', 'Error al cargar el formulario de edición.');
        }
    }

    public function update(Request $request, Medidor $medidor)
    {
        $request->validate([
            'cliente_id' => 'nullable|exists:clientes,id',
            'numero_serie' => 'required|unique:medidores,numero_serie,'.$medidor->id,
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