<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trabajador extends Model
{
    use HasFactory;

    protected $table = 'trabajador';
    protected $primaryKey = 'idtrabajador';
    protected $fillable = [
        'nombre',
        'apellidos',
        'SEXO',
        'fecha_nacimiento',
        'num_documento',
        'direccion',
        'telefono',
        'email'
    ];

    public function venta()
    {
        return $this->hasMany(Venta::class, 'idtrabajador');
    }
}