<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Direcciones extends Model
{
    use HasFactory;

    protected $table = 'direcciones'; 

    protected $fillable = [
        'identificador_direccion',
        'direccion',
        'poblacion',
        'codigo_postal',
        'provincia',
        'pais'
    ];

    public function scopeActive($query) {
        return $query->where('activo',1);
    }


    // Relación inversa con el modelo Cliente
    public function cliente()
    {
        return $this->belongsTo(Clientes::class);
    }   

    
}
