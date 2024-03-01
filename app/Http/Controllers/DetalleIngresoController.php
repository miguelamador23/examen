<?php

namespace App\Http\Controllers;

use App\Models\DetalleIngreso;
use App\Models\Articulo;

use Illuminate\Http\Request;

class DetalleIngresoController extends Controller
{

    public function registerPurchase(Request $request, Articulo $articulo)
    {
        
        $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'precio_compra' => 'required|numeric|min:0',
        ]);

     
        if ($request->cantidad > $articulo->stock_actual) {
            return redirect()->route('articulos.index')->with('error', 'No hay stock suficiente para realizar la compra.');
        }

   
        $ingreso = DetalleIngreso::firstOrCreate([
            'fecha' => now(),
        ]);

 
        $detalleIngreso = new DetalleIngreso();
        $detalleIngreso->idingreso = $ingreso->idingreso;
        $detalleIngreso->idarticulo = $articulo->idarticulo;
        $detalleIngreso->precio_compra = $request->precio_compra;
        $detalleIngreso->precio_venta = $articulo->precio_venta;
        $detalleIngreso->stock_inicial = $articulo->stock_inicial + $request->cantidad;
        $detalleIngreso->stock_actual = $articulo->stock_actual + $request->cantidad;
        $detalleIngreso->fecha_produccion = now();
        $detalleIngreso->fecha_vencimiento = $articulo->fecha_vencimiento;
        $detalleIngreso->save();

    
        $articulo->stock_inicial += $request->cantidad;
        $articulo->stock_actual += $request->cantidad;
        $articulo->save();

        return redirect()->route('articulos.index')->with('success', 'Compra registrada correctamente.');
    }


    public function show(DetalleIngreso $ingreso)
    {
        return view('ingresos.show', compact('ingreso'));
    }


    public function edit(DetalleIngreso $ingreso)
    {
        return view('ingresos.edit', compact('ingreso'));
    }


    public function update(Request $request, DetalleIngreso $ingreso)
    {
        $request->validate([
            'estado' => 'required',
        ]);

        $ingreso->update($request->all());

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente.');
    }


    public function destroy(DetalleIngreso $ingreso)
    {
        $ingreso->delete();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }


    public function delete(DetalleIngreso $ingreso)
    {
        $ingreso->delete();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }


    public function cancel(DetalleIngreso $ingreso)
    {
        $ingreso->estado = 'CANCELADO';
        $ingreso->save();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso cancelado correctamente.');
    }


    public function confirm(DetalleIngreso $ingreso)
    {
        $ingreso->estado = 'CONFIRMADO';
        $ingreso->save();
        return redirect()->route('ingresos.index')->with('success', 'Ingreso confirmado correctamente.');
    }


   
}