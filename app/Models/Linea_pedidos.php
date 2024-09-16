<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Linea_pedidos extends Model
{
    use HasFactory;

    protected $table = 'linea_pedidos'; 

    protected $fillable = [
        'articulo_id',
        'articulo',
        'trazabilidad',
        'kg_caja',
        'referencia',
        'cajas',
        'cantidad',
        'precio',
        'comision',
        'lote',
        'estado'
    ];

    public function scopeActive($query) {
        return $query->where('activo',1);
    }


    // Relación inversa con el modelo Pedidos
    public function pedidos()
    {
        return $this->belongsTo(Pedidos::class);
    }   


}
