<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    use HasFactory;
    protected $table = 'clientes';

    protected $fillable = [
        'nombre_comercial', 
        'razon_social',
        'cif', 
        'email',
        'direccion_facturacion',
        'poblacion',
        'codigo_postal',
        'provincia', 
        'pais',
        'telefono',
        'contacto',
        'notas'
    ];

    public function scopeActive($query) {
        return $query->where('activo',1);
    }

    // Relación uno a muchos con las direcciones de un cliente
    public function direcciones()
    {
        return $this->hasMany(Direcciones::class);
    }

    // Método para obtener todas las direcciones de un cliente
    public function obtenerDirecciones()
    {
        return $this->direcciones;
    }        
}


