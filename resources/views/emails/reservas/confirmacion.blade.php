<x-mail::message>
<img src="https://cdmontecanal.com/wp-content/uploads/2022/03/MCEB0-Montecanal-IC-Enero2025-logotipoESTANDAR-burgundy-RGB-150dpi-e1761031101860.png" width="150" style="display: block; margin: 0 auto;">

# ¡Hola, {{ $reserva->nombre_cliente }}!

Tu reserva para las instalaciones del **Club Deportivo Montecanal** ha sido registrada con éxito. 

Aquí tienes el resumen de tu solicitud:

<x-mail::panel>
**Fecha del Evento:** {{ \Carbon\Carbon::parse($reserva->fecha_evento)->format('d/m/Y') }}
</x-mail::panel>

### Desglose de tu pedido:

<x-mail::table>
| Concepto | Cantidad | Precio |
|:---------|:--------:|-------:|
| **Paquete: {{ $reserva->paquete->nombre }}** | 1 | {{ number_format($reserva->paquete->precio, 2) }} € |
@foreach($reserva->extras as $extra)
| {{ $extra->nombre }} | {{ $extra->pivot->cantidad }} | {{ number_format($extra->pivot->precio_unitario * $extra->pivot->cantidad, 2) }} € |
@endforeach
| | | |
| **TOTAL A PAGAR** | | **{{ number_format($reserva->total_calculado, 2) }} €** |
</x-mail::table>

*(Nota: Recuerda que el día del evento se requerirá una fianza de 50€ en efectivo).*

<x-mail::button :url="'https://cdmontecanal.test/normativa'">
Ver Normativa del Club
</x-mail::button>

<x-mail::button :url="$urlCancelacion" color="error">
Cancelar mi reserva
</x-mail::button>

<p style="font-size: 0.8em; color: #666; text-align: center;">
    Este enlace de cancelación es personal y seguro. Por motivos de seguridad, caducará en 7 días.
</p>

¡Gracias por confiar en nosotros!<br>
La directiva del {{ config('app.name') }}
</x-mail::message>