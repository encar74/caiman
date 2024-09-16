<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        'tipo_producto', 
        'referencia',
        'nombre_articulo', 
        'trazabilidad',
        'kg_caja',
        'precio',
        'iva',
        'stock',
        'notas'
    ];

    public function scopeActive($query)
    {
        return $query->where('activo', 1);
    }

    public function tipoProducto()
    {
        return $this->belongsTo(TipoProducto::class, 'tipo_producto');
    }

    public static function getTipoProductoNombre($id)
    {
        $producto = self::find($id);
        return $producto ? $producto->tipoProducto->nombre : null;
    }
}
