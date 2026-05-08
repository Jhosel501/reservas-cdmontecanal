<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    // Con esta función, Laravel hace la magia de la tabla pivote por debajo
    public function extras()
    {
        
        return $this->belongsToMany(Extra::class, 'extra_reserva')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }

    // Le decimos a la reserva cómo encontrar el paquete que se ha comprado
    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }
}