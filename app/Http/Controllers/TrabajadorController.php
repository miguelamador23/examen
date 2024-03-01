<?php

namespace App\Http\Controllers;

use App\Models\Trabajador;
use Illuminate\Http\Request;

class TrabajadorController extends Controller
{

    public function index()
    {
        $trabajadores = Trabajador::all();
        return view('trabajadores.index', compact('trabajadores'));
    }


    public function create()
    {
        return view('trabajadores.create');
    }

  
    public function store(Request $request)
    {
       
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'SEXO' => 'required|string|max:1',
            'fecha_nacimiento' => 'required|date',
            'num_documento' => 'required|string|max:20|unique:trabajadores,num_documento',
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:trabajadores,email',
        ]);


        $trabajador = Trabajador::create($request->all());

        return redirect()->route('trabajadores.index')->with('success', 'Trabajador creado correctamente.');
    }

  
    public function show(Trabajador $trabajador)
    {
        return view('trabajadores.show', compact('trabajador'));
    }

  
    public function edit(Trabajador $trabajador)
    {
        return view('trabajadores.edit', compact('trabajador'));
    }

  
    public function update(Request $request, Trabajador $trabajador)
    {
        
        $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'SEXO' => 'required|string|max:1',
            'fecha_nacimiento' => 'required|date',
            'num_documento' => "required|string|max:20|unique:trabajadores,num_documento,{$trabajador->idtrabajador}",
            'direccion' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'email' => "required|string|email|max:255|unique:trabajadores,email,{$trabajador->idtrabajador}",
        ]);


        $trabajador->update($request->all());

      
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador actualizado correctamente.');
    }


    public function destroy(Trabajador $trabajador)
    {
        // Delete the trabajador
        $trabajador->delete();

    
        return redirect()->route('trabajadores.index')->with('success', 'Trabajador eliminado correctamente.');
    }

}