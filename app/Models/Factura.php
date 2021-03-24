<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    use HasFactory;

    protected $fillable = [
        'num', 'lectura1', 'lectura2', 'total', 'fecha', 'cancelado', 'client_id'
    ];

    public function cancelados()
    {
        return $this->hasMany(Cancelado::class, 'factura_id', 'id');
    }
}
