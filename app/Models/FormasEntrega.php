<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\FormasEntrega;

class FormasEntrega extends Model
{
    use HasFactory;
    protected $table = 'formas_entrega';

    protected $fillable = [
        'nombre' => 'required',
        'icono' => 'required',
    ];

    public function scopeActive($query) {
        return $query->where('activo',1);
    }

}


