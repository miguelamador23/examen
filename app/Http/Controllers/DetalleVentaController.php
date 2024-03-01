<?php

namespace App\Http\Controllers;

use App\Models\DetalleVenta;
use App\Models\Articulo;
use App\Models\Venta;
use Illuminate\Http\Request;

class DetalleVentaController extends Controller
{

    public function registerSale(Request $request, Articulo $articulo)
    {
 
        $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'precio_venta' => 'required|numeric|min:0',
        ]);


        if ($request->cantidad > $articulo->stock_actual) {
            return redirect()->route('articulos.index')->with('error', 'No hay stock suficiente para realizar la venta.');
        }


        $ventaId = $request->idventa ?? null;
        $venta = $ventaId ? Venta::findOrFail($ventaId) : Venta::create([
            'fecha' => now(),
            'idcliente' => auth()->user()->idcliente,
            'estado' => 'PENDIENTE',
            'tipo_comprobante' => 'BOLETA',
            'serie' => 'A',
            'correlativo' => 1,
            'igv' => 0.18,
        ]);

        // Create a new detalle venta
        $detalleVenta = new DetalleVenta();
        $detalleVenta->idventa = $venta->idventa;
        $detalleVenta->idarticulo = $articulo->idarticulo;
        $detalleVenta->cantidad = $request->cantidad;
        $detalleVenta->precio_venta = $request->precio_venta;
        $detalleVenta->descuento = 0;
        $detalleVenta->save();

       
        $articulo->stock_actual -= $request->cantidad;
        $articulo->save();

  
        if ($ventaId) {
            return redirect()->route('ventas.show', $venta)->with('success', 'Venta actualizada correctamente.');
        } else {
            return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');
        }
    }


    public function show(Venta $venta)
    {
        return view('ventas.show', compact('venta'));
    }


    public function edit(Venta $venta)
    {
        return view('ventas.edit', compact('venta'));
    }


    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'estado' => 'required',
        ]);

        $venta->update($request->all());

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada correctamente.');
    }


    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }


    public function confirm(Venta $venta)
    {
        $venta->estado = 'CONFIRMADA';
        $venta->save();
        return redirect()->route('ventas.index')->with('success', 'Venta confirmada correctamente.');
    }


    public function cancel(Venta $venta)
    {
        $venta->estado = 'CANCELADA';
        $venta->save();
        return redirect()->route('ventas.index')->with('success', 'Venta cancelada correctamente.');
    }


    public function delete(Venta $venta)
    {
        $venta->delete();
        return redirect()->route('ventas.index')->with('success', 'Venta eliminada correctamente.');
    }

}