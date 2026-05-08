<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Cancelada - CD Montecanal</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --burgundy: #800020;
            --gold: #C5A059;
            --slate: #2C3E50;
        }
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
            color: var(--slate);
        }
        .card {
            background: white;
            padding: 2.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            border-top: 5px solid var(--burgundy);
        }
        .icon-box {
            width: 70px;
            height: 70px;
            background: #fff5f5;
            color: var(--burgundy);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin: 0 auto 1.5rem;
        }
        h1 { color: var(--burgundy); margin-bottom: 0.5rem; }
        p { line-height: 1.6; color: #666; }
        .details {
            background: #fdfdfd;
            border: 1px solid #eee;
            padding: 1rem;
            border-radius: 8px;
            margin: 1.5rem 0;
            font-size: 0.9rem;
        }
        .btn-web {
            display: inline-block;
            padding: 0.8rem 1.5rem;
            background: var(--slate);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .btn-web:hover { background: var(--burgundy); }
    </style>
</head>
<body>
    <div class="card">
        <div class="icon-box">✕</div>
        <h1>Reserva Cancelada</h1>
        <p>Hola <strong>{{ $reserva->nombre_cliente }}</strong>,</p>
        <p>Tal como has solicitado, hemos tramitado la cancelación de tu reserva para el Club Deportivo Montecanal.</p>
        
        <div class="details">
            <strong>Fecha original:</strong> {{ \Carbon\Carbon::parse($reserva->fecha_evento)->format('d/m/Y') }}<br>
            <strong>Paquete:</strong> {{ $reserva->paquete->nombre }}
        </div>

        <p>Esperamos verte de nuevo muy pronto por nuestras instalaciones.</p>
        
        <a href="https://cdmontecanal.com" class="btn-web">Volver a la web oficial</a>
    </div>
</body>
</html>