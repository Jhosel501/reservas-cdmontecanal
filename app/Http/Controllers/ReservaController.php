<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Paquete;
use App\Models\Extra;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // 1. VALIDACIÓN BÁSICA (Tu primera barrera de Ciberseguridad)
        // Obligamos a que nos envíen los datos con el formato correcto.
        $validated = $request->validate([
            'paquete_id' => 'required|exists:paquetes,id',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'fecha_evento' => 'required|date',
            // Los extras son opcionales, pero si vienen, deben ser un array
            'extras' => 'nullable|array' 
        ]);

        // 2. CALCULAR PRECIO REAL EN EL SERVIDOR (Nunca confiar en el Frontend)
        $paquete = Paquete::findOrFail($validated['paquete_id']);
        $totalCalculado = $paquete->precio;

        // 3. GUARDAR LA RESERVA PRINCIPAL
        $reserva = new Reserva();
        $reserva->paquete_id = $paquete->id;
        $reserva->nombre_cliente = $validated['nombre'];
        $reserva->apellido_cliente = $validated['apellido'];
        $reserva->email_cliente = $validated['email'];
        $reserva->telefono_cliente = $validated['telefono'];
        $reserva->fecha_evento = $validated['fecha_evento'];
        $reserva->total_calculado = $totalCalculado; // Por ahora metemos el precio del paquete
        $reserva->estado = 'pendiente';
        $reserva->save(); // Aquí se genera el ID de la reserva en la base de datos

        // 4. GUARDAR LOS EXTRAS Y RECALCULAR EL TOTAL
        if (!empty($validated['extras'])) {
            foreach ($validated['extras'] as $extraFront) {
                // Buscamos el extra real en nuestra base de datos
                $extraDB = Extra::find($extraFront['id']);
                
                if ($extraDB) {
                    $cantidad = $extraFront['cantidad'];
                    
                    // Unimos la reserva con el extra en la tabla pivote
                    $reserva->extras()->attach($extraDB->id, [
                        'cantidad' => $cantidad,
                        'precio_unitario' => $extraDB->precio // Cogemos el precio SEGURO de nuestra BD
                    ]);

                    // Sumamos al total
                    $totalCalculado += ($extraDB->precio * $cantidad);
                }
            }
            
            // Actualizamos la reserva con el precio total definitivo
            $reserva->total_calculado = $totalCalculado;
            $reserva->save();
        }

        // 5. DEVOLVER RESPUESTA AL JAVASCRIPT
        return response()->json([
            'success' => true,
            'message' => '¡Reserva creada con éxito!',
            'reserva_id' => $reserva->id
        ]);
    }
}