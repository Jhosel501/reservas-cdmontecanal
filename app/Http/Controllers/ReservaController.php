<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Reserva;
use App\Models\Paquete;
use App\Models\Extra;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Http;

class ReservaController extends Controller
{
    public function store(Request $request)
    {
        // 1. EL ESCUDO DE VALIDACIÓN (Protección de Base de Datos y Fechas)
        $validador = Validator::make($request->all(), [
            'paquete_id' => 'required|exists:paquetes,id',
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email',
            'telefono' => 'required|string|max:20',
            'fecha_evento' => 'required|date|after:today', // <-- Bloqueo de fechas pasadas e iguales a hoy
            // Los extras son opcionales, pero si vienen, deben ser un array
            'extras' => 'nullable|array',
            // Requerimos que el frontend nos envíe el token de Google
            'recaptcha_token' => 'required|string' 
        ]);

        // Si alguien se salta el frontend o intenta enviar datos corruptos
        if ($validador->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación: ' . $validador->errors()->first()
            ]);
        }

        // Extraemos los datos ya limpios y seguros
        $validated = $validador->validated();

        // --- NUEVA BARRERA: VERIFICACIÓN RECAPTCHA CON GOOGLE ---
        // Hacemos una petición por detrás a la API de Google para validar el token
        $respuestaGoogle = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $validated['recaptcha_token'],
            'remoteip' => $request->ip() // Enviamos la IP del usuario como capa extra de seguridad
        ]);

        // Si Google nos dice que el token es falso, ha caducado, o es un bot
        if (!$respuestaGoogle->json('success')) {
            return response()->json([
                'success' => false,
                'message' => 'Validación de seguridad fallida. Por favor, recarga la página y vuelve a marcar la casilla "No soy un robot".'
            ]);
        }
        // ---------------------------------------------------------

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
        
        // --- 1. GENERAR URL FIRMADA TEMPORAL ---
        // Creamos un enlace que solo sirve para ESTA reserva y que caduca en 7 días (por seguridad).
        $urlCancelacion = URL::temporarySignedRoute(
            'reservas.cancelar',         // El nombre de la ruta que pusimos en web.php
            now()->addDays(7),            // Tiempo de validez del enlace
            ['reserva' => $reserva->id]   // El ID que queremos proteger con la firma
        );

        // --- ENVIAR EL CORREO EN SEGUNDO PLANO ---
        Mail::to($reserva->email_cliente)->queue(new ReservaConfirmada($reserva, $urlCancelacion));

        // 5. DEVOLVER RESPUESTA AL JAVASCRIPT
        return response()->json([
            'success' => true,
            'message' => '¡Reserva creada con éxito!',
            'reserva_id' => $reserva->id
        ]);
    }

    /**
     * Método para cancelar la reserva desde el enlace firmado del correo.
     */
    public function cancel(Reserva $reserva)
    {
        // 1. Verificamos si la reserva ya estaba cancelada para no repetir el proceso
        if ($reserva->estado === 'cancelada') {
            return view('reservas.cancelada', compact('reserva'));
        }

        // 2. Ejecutamos la lógica de cancelación
        $reserva->estado = 'cancelada';
        $reserva->save();

        // 3. Retornamos la vista profesional en lugar de un string
        // Usamos 'compact' para pasar los datos de la reserva a la plantilla Blade
        return view('reservas.cancelada', compact('reserva'));
    }
}