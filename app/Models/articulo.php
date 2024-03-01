<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\DetalleIngreso;
use App\Models\DetalleVenta;

class Articulo extends Model
{
    use HasFactory;

    protected $table = 'articulos';
    protected $primaryKey = 'idarticulo';
    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'imagen',
        'idcategoria',
        'idpresentacion',
        'precio_compra',
        'precio_venta',
        'stock_inicial',
        'stock_actual',
        'fecha_produccion',
        'fecha_vencimiento'
    ];


    public function detalleIngresos()
    {
        return $this->hasMany(DetalleIngreso::class, 'idarticulo');
    }

    public function detalleVentas()
    {
        return $this->hasMany(DetalleVenta::class, 'idarticulo');
    }
}