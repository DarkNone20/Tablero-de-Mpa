<?php

namespace App\Http\Controllers;

use App\Models\TableroNota;
use Illuminate\Http\Request;

class TableroController extends Controller
{
    // Vista 1: Formulario de escritura y gestión
    public function escribir(Request $request)
    {
        $fechaSeleccionada = $request->input('fecha', now()->toDateString());

        $generales = TableroNota::where('tipo', 'general')
            ->latest()
            ->get();

        $porFecha = TableroNota::where('tipo', 'fecha')
            ->whereDate('fecha', $fechaSeleccionada)
            ->latest()
            ->get();

        return view('tablero.escribir', compact('generales', 'porFecha', 'fechaSeleccionada'));
    }

    // Guardar nota nueva
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo'    => 'nullable|string|max:150',
            'contenido' => 'required|string',
            'tipo'      => 'required|in:general,fecha',
            'fecha'     => 'required_if:tipo,fecha|nullable|date',
        ]);

        TableroNota::create([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'tipo'      => $request->tipo,
            'fecha'     => $request->tipo === 'fecha' ? $request->fecha : null,
        ]);

        return back()->with('success', 'Información agregada al tablero.');
    }

    // Eliminar nota
    public function eliminar($id)
    {
        TableroNota::findOrFail($id)->delete();
        return back()->with('success', 'Registro eliminado.');
    }

    // Vista 2: Pantalla de visualización
    public function mostrar(Request $request)
    {
        $fechaSeleccionada = $request->input('fecha', now()->toDateString());
        return view('tablero.mostrar', compact('fechaSeleccionada'));
    }

    // API interna que devuelve JSON cada 5 segundos
    public function obtenerDatos(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());

        $generales = TableroNota::where('tipo', 'general')
            ->latest()
            ->get(['id', 'titulo', 'contenido']);

        $porFecha = TableroNota::where('tipo', 'fecha')
            ->whereDate('fecha', $fecha)
            ->latest()
            ->get(['id', 'titulo', 'contenido', 'fecha']);

        return response()->json([
            'generales' => $generales,
            'porFecha'  => $porFecha,
            'hora'      => now()->format('h:i:s A'),
        ]);
    }

    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'titulo'    => 'nullable|string|max:150',
            'contenido' => 'required|string',
            'tipo'      => 'required|in:general,fecha',
            'fecha'     => 'required_if:tipo,fecha|nullable|date',
        ]);

        $nota = TableroNota::findOrFail($id);

        $nota->update([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'tipo'      => $request->tipo,
            'fecha'     => $request->tipo === 'fecha' ? $request->fecha : null,
        ]);

        return back()->with('success', 'Información actualizada correctamente.');
    }
}