<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Trabajador;
use App\Models\detalleVenta;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'venta';
    protected $primaryKey = 'idventa';
    protected $fillable = [
        'idcliente',
        'idtrabajador',
        'fecha',
        'tipo_comprobante',
        'serie',
        'correlativo',
        'igv',
        'estado'
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'idcliente');
    }

    public function trabajador()
    {
        return $this->belongsTo(Trabajador::class, 'idtrabajador');
    }

    public function detalleVentas()
    {
        return $this->hasMany(detalleVenta::class, 'idventa');
    }
}