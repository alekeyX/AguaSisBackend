<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod', 'name', 'detail', 'lote_id'
    ];

    public function telefonos()
    {
        return $this->hasMany(Telefono::class, 'client_id', 'id');
    }

    public function facturas()
    {
        return $this->hasMany(Factura::class, 'client_id', 'id');
    }
}
