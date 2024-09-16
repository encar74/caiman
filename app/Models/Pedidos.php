<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pedidos;

class Pedidos extends Model
{
    use HasFactory;
    protected $table = 'pedidos';

    protected $fillable = [
        'cliente', 
        'destino', 
        'fecha', 
        'fecha_entrega', 
        'transporte', 
        'tipo',
        'importe_total',
        'estado', 
        'notas' 
        
    ];

    // Relación inversa con el modelo Cliente
    public function cliente()
    {
        
        return $this->belongsTo(Clientes::class,'id_cliente');
    
    }   

    public function direccion()
    {
        
        return $this->belongsTo(Direcciones::class,'id_direccion');
    
    }       

      // Relación uno a muchos con las direcciones de un cliente
      public function linea_pedidos()
      {
          return $this->hasMany(Linea_pedidos::class);
      }

    public function scopeActive($query) {
        return $query->where('activo',1);
    }

}


