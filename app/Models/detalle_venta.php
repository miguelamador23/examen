<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Articulo;
use App\Models\Venta;

class DetalleVenta extends Model
{
    use HasFactory;

    protected $table = 'detalle_venta';
    protected $primaryKey = 'iddetalle_venta';
    protected $fillable = [
        'idventa',
        'iddetalle_ingreso',
        'cantidad',
        'precio_venta',
        'descuento'
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'iddetalle_ingreso');
    }

    public function venta()
    {
        return $this->belongsTo(Venta::class, 'idventa');
    }
}