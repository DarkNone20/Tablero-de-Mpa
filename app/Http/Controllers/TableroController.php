<?php

namespace App\Http\Controllers;

use App\Models\TableroNota;
use Illuminate\Http\Request;

class TableroController extends Controller
{
    public function escribir(Request $request)
    {
        $fechaSeleccionada =$request->input('fecha', now()->toDateString());

        $generales = TableroNota::where('tipo', 'general')
            ->latest()
            ->get();

        $porFecha = TableroNota::where('tipo', 'fecha')
            ->whereDate('fecha', $fechaSeleccionada)
            ->latest()
            ->get();

        $pruebasSoftware = TableroNota::where('tipo', 'pruebas_software')
            ->whereDate('fecha', $fechaSeleccionada)
            ->latest()
            ->get();

        return view('tablero.escribir', compact('generales', 'porFecha', 'pruebasSoftware', 'fechaSeleccionada'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo'    => 'nullable|string|max:150',
            'contenido' => 'required|string',
            'tipo'      => 'required|in:general,fecha,pruebas_software',
            'fecha'     => 'required_if:tipo,fecha,pruebas_software|nullable|date',
        ]);

        TableroNota::create([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'tipo'      => $request->tipo,
            'fecha'     => in_array($request->tipo, ['fecha', 'pruebas_software']) ?$request->fecha : null,
        ]);

        return back()->with('success', 'Información agregada al tablero.');
    }

    public function actualizar(Request $request,$id)
    {
        $request->validate([
            'titulo'    => 'nullable|string|max:150',
            'contenido' => 'required|string',
            'tipo'      => 'required|in:general,fecha,pruebas_software',
            'fecha'     => 'required_if:tipo,fecha,pruebas_software|nullable|date',
        ]);

        $nota = TableroNota::findOrFail($id);

        $nota->update([
            'titulo'    => $request->titulo,
            'contenido' => $request->contenido,
            'tipo'      => $request->tipo,
            'fecha'     => in_array($request->tipo, ['fecha', 'pruebas_software']) ?$request->fecha : null,
        ]);

        return back()->with('success', 'Información actualizada correctamente.');
    }

    public function eliminar($id)
    {
        TableroNota::findOrFail($id)->delete();
        return back()->with('success', 'Registro eliminado.');
    }

    public function mostrar(Request $request)
    {
        $fechaSeleccionada =$request->input('fecha', now()->toDateString());
        return view('tablero.mostrar', compact('fechaSeleccionada'));
    }

    public function obtenerDatos(Request $request)
    {
        $fecha =$request->input('fecha', now()->toDateString());

        $generales = TableroNota::where('tipo', 'general')
            ->latest()
            ->get(['id', 'titulo', 'contenido']);

        $porFecha = TableroNota::where('tipo', 'fecha')
            ->whereDate('fecha', $fecha)
            ->latest()
            ->get(['id', 'titulo', 'contenido', 'fecha']);

        $pruebasSoftware = TableroNota::where('tipo', 'pruebas_software')
            ->whereDate('fecha', $fecha)
            ->latest()
            ->get(['id', 'titulo', 'contenido', 'fecha']);

        return response()->json([
            'generales'       => $generales,
            'porFecha'        => $porFecha,
            'pruebasSoftware' => $pruebasSoftware,
            'hora'            => now()->format('h:i:s A'),
        ]);
    }
}