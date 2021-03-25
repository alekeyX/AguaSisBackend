<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function clients()
    {
        return $this->hasMany(Client::class, 'lote_id', 'id');
    }
}
