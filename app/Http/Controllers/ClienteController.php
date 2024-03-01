<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

  
    public function registerSale(Request $request, Cliente $cliente)
    {
   
        $request->validate([
            'idventa' => 'required|exists:venta,idventa',
            'total' => 'required|numeric|min:0',
        ]);

      
        $venta = Venta::findOrFail($request->idventa);

    
        if ($venta->idcliente !== $cliente->idcliente) {
            return redirect()->route('clientes.index')->with('error', 'El cliente no coincide con la venta especificada.');
        }

     
        $venta->total = $request->total;
        $venta->save();

  
        return redirect()->route('clientes.index')->with('success', 'Venta registrada correctamente.');
    }


    public function delete(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }


    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'Cliente eliminado correctamente.');
    }


    public function confirm(Cliente $cliente)
    {
        $cliente->estado = 'CONFIRMADO';
        $cliente->save();
        return redirect()->route('clientes.index')->with('success', 'Cliente confirmado correctamente.');
    }


    public function cancel(Cliente $cliente)
    {
        $cliente->estado = 'CANCELADO';
        $cliente->save();
        return redirect()->route('clientes.index')->with('success', 'Cliente cancelado correctamente.');
    }

    


}