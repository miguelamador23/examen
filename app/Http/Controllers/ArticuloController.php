<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\DetalleIngreso;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;

class ArticuloController extends Controller
{
    // ... Previous methods

    /**
     * Register a new purchase for the specified articulo.
     */
    public function registerPurchase(Request $request, Articulo $articulo)
    {
        // Validate request data
        $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'precio_compra' => 'required|numeric|min:0',
        ]);

        // Create a new detalle ingreso
        $detalleIngreso = new DetalleIngreso();
        $detalleIngreso->idarticulo = $articulo->idarticulo;
        $detalleIngreso->precio_compra = $request->precio_compra;
        $detalleIngreso->precio_venta = $articulo->precio_venta;
        $detalleIngreso->stock_inicial = $articulo->stock_inicial + $request->cantidad;
        $detalleIngreso->stock_actual = $articulo->stock_actual + $request->cantidad;
        $detalleIngreso->fecha_produccion = now();
        $detalleIngreso->fecha_vencimiento = $articulo->fecha_vencimiento;
        $detalleIngreso->save();

        // Update the articulo stock
        $articulo->stock_inicial += $request->cantidad;
        $articulo->stock_actual += $request->cantidad;
        $articulo->save();

        // Redirect or return a response
        return redirect()->route('articulos.index')->with('success', 'Compra registrada correctamente.');
    }

    /**
     * Register a new sale for the specified articulo.
     */
    public function registerSale(Request $request, Articulo $articulo)
    {
        // Validate request data
        $request->validate([
            'cantidad' => 'required|numeric|min:1',
            'precio_venta' => 'required|numeric|min:0',
        ]);

        // Check if there is enough stock
        if ($request->cantidad > $articulo->stock_actual) {
            return redirect()->route('articulos.index')->with('error', 'No hay stock suficiente para realizar la venta.');
        }

        // Create a new detalle venta
        $detalleVenta = new DetalleVenta();
        $detalleVenta->idarticulo = $articulo->idarticulo;
        $detalleVenta->iddetalle_ingreso = $request->iddetalle_ingreso;
        $detalleVenta->cantidad = $request->cantidad;
        $detalleVenta->precio_venta = $request->precio_venta;
        $detalleVenta->descuento = 0;
        $detalleVenta->save();

      
        $articulo->stock_actual -= $request->cantidad;
        $articulo->save();

      
        return redirect()->route('articulos.index')->with('success', 'Venta registrada correctamente.');
    }


    public function show(Articulo $articulo)
    {
        // Retrieve the related detalleIngresos and detalleVentas
        $detalleIngresos = $articulo->detalleIngresos;
        $detalleVentas = $articulo->detalleVentas;

        return view('articulos.show', compact('articulo', 'detalleIngresos', 'detalleVentas'));
    }


    public function edit(Articulo $articulo)
    {
        return view('articulos.edit', compact('articulo'));
    }


    public function update(Request $request, Articulo $articulo)
    {
        $articulo->update($request->all());
        return redirect()->route('articulos.index')->with('success', 'Artículo actualizado correctamente.');
    }


    public function destroy(Articulo $articulo)
    {
        $articulo->delete();
        return redirect()->route('articulos.index')->with('success', 'Artículo eliminado correctamente.');
    }

}