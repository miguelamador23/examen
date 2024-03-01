<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'cliente';
    protected $primaryKey = 'idcliente';
    protected $fillable = [
        'nombre',
        'apellidos',
        'SEXO',
        'fecha_nacimiento',
        'tipo_documento',
        'num_documento',
        'direccion',
        'telefono',
        'email'
    ];

    public function venta()
    {
        return $this->hasMany(Venta::class, 'idcliente');
    }
}