<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Articulo;


class DetalleIngreso extends Model
{
    use HasFactory;

    protected $table = 'detalle_ingreso';
    protected $primaryKey = 'idingreso';
    protected $fillable = [
        'idarticulo',
        'precio_compra',
        'precio_venta',
        'stock_inicial',
        'stock_actual',
        'fecha_produccion',
        'fecha_vencimiento'
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class, 'idarticulo');
    }

    public function ingreso()
    {
        return $this->belongsTo(DetalleIngreso::class, 'idingreso');
    }
}