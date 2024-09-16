<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Uvas;

class Uvas extends Model
{
    use HasFactory;
    protected $table = 'uvas';

    protected $fillable = [
        'referencia' => 'required',
        'nombre' => 'required',
        'precio' => 'required',
        'notas'
    ];

    public function scopeActive($query) {
        return $query->where('activo',1);
    }

}


