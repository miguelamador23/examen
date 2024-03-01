<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
 
    public function index()
    {
        $ventas = Venta::where('idcliente', Auth::user()->idcliente)->get();
        return view('ventas.index', compact('ventas'));
    }


    public function create()
    {
        $articulos = Articulo::all();
        return view('ventas.create', compact('articulos'));
    }

  
    public function store(Request $request)
    {
     
        $request->validate([
            'articulos' => 'required|array',
            'articulos.*.idarticulo' => 'required|exists:articulos,idarticulo',
            'articulos.*.cantidad' => 'required|numeric|min:1',
            'articulos.*.precio_venta' => 'required|numeric|min:0',
        ]);

     
        DB::beginTransaction();

        try {
      
            $venta = Venta::create([
                'fecha' => now(),
                'idcliente' => Auth::user()->idcliente,
                'estado' => 'PENDIENTE',
                'tipo_comprobante' => 'BOLETA',
                'serie' => 'A',
                'correlativo' => 1,
                'igv' => 0.18,
            ]);


            foreach ($request->articulos as $articuloData) {
                $articulo = Articulo::findOrFail($articuloData['idarticulo']);

        
                if ($articuloData['cantidad'] > $articulo->stock_actual) {
                    throw new \Exception("No hay stock suficiente para el artículo {$articulo->nombre}.");
                }

          
                DetalleVenta::create([
                    'idventa' => $venta->idventa,
                    'idarticulo' => $articuloData['idarticulo'],
                    'cantidad' => $articuloData['cantidad'],
                    'precio_venta' => $articuloData['precio_venta'],
                    'descuento' => 0,
                ]);

                $articulo->stock_actual -= $articuloData['cantidad'];
                $articulo->save();
            }

          
            DB::commit();

      
            return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente.');

        } catch (\Exception $e) {

            DB::rollback();

            if ($venta) {
                $venta->delete();
            }

            // Redirect or return an error response
            return redirect()->route('ventas.create')->with('error', $e->getMessage());
        }
    }

    public function show(Venta $venta)
    {
        $detalleVentas = $venta->detalleVentas;
        return view('ventas.show', compact('venta', 'detalleVentas'));
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

}