<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
// CSRF token para peticiones AJAX
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Zona Barbacoas — Club Deportivo Montecanal</title>
<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300;400;500;600;700;800&family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

<!-- HEADER -->
<header>
  <div class="header-inner">
    <div class="logo">
      Club Deportivo
      <span>Montecanal</span>
    </div>
    <nav>
      <a href="#reservar" class="active">Reservar</a>
      <a href="#info">Instalaciones</a>
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="hero-banner">
  <div class="breadcrumb">Servicios · Zona Barbacoas</div>
  <h1>Zona Barbacoas</h1>
  <p>El plan favorito de toda la familia. Disfruta de un día de barbacoa perfecto junto a los tuyos.</p>
</section>

<!-- FEATURES -->
<section class="features">
  <div class="features-grid">
    <div class="feature-item">
      <div class="feature-icon">🔥</div>
      <h3>3 Barbacoas</h3>
      <p>Tres zonas completamente independientes con parrilla incluida</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon">⛺</div>
      <h3>Zona merendero</h3>
      <p>Mesa y pérgola propia para cada grupo, con privacidad total</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon">🏐</div>
      <h3>Zona deportiva</h3>
      <p>Acceso incluido a actividades al aire libre para todos los grupos</p>
    </div>
    <div class="feature-item">
      <div class="feature-icon">📋</div>
      <h3>Reserva online</h3>
      <p>Selecciona tu paquete, añade extras y confirma en minutos</p>
    </div>
  </div>
</section>

<!-- INFO SECTION -->
<section class="section info-section" id="info">
  <div class="container">
    <div class="section-eyebrow">Nuestras instalaciones</div>
    <h2 class="section-title">Un espacio para <span>disfrutar</span></h2>
    <div class="divider"></div>
    <p class="section-desc">
      Disponemos de <strong>tres zonas de barbacoa completamente independientes</strong>, cada una con bancada y pérgola propia. Las instalaciones pueden reservarse de forma individual o simultánea por hasta tres grupos distintos.
    </p>

    <div class="info-cards">
      <div class="info-card">
        <div class="info-card-icon">⏰</div>
        <h4>Horario de uso</h4>
        <p>Acceso disponible de <strong>12:00 h a 20:00 h</strong>. Rogamos puntualidad en la entrada y salida para garantizar el correcto funcionamiento del servicio.</p>
      </div>
      <div class="info-card">
        <div class="info-card-icon">🏐</div>
        <h4>Zona deportiva</h4>
        <p>Todos los grupos disponen de acceso a la <strong>zona deportiva</strong> habilitada para actividades al aire libre, como complemento a la experiencia.</p>
      </div>
      <div class="info-card">
        <div class="info-card-icon">🏕️</div>
        <h4>Exclusiva o compartida</h4>
        <p>Reserva <strong>en exclusividad</strong> (paquete Grande) o comparte el espacio con hasta otros dos grupos, cada uno en su área privada e independiente.</p>
      </div>
    </div>

    <div class="rules-box">
      <span style="font-size:1.4rem; flex-shrink:0; margin-top:0.1rem;">📜</span>
      <p>
        <strong>Normas de uso y convivencia —</strong> El correcto uso de las instalaciones y un comportamiento cívico y respetuoso son condiciones <strong>indispensables</strong>. Cualquier conducta inapropiada o uso indebido podrá ser motivo de <strong>expulsión inmediata sin devolución del importe abonado</strong>, en aplicación del derecho de admisión que nos reservamos como empresa. Confiamos en la responsabilidad de nuestros clientes para mantener un entorno agradable y seguro para todos.
      </p>
    </div>
  </div>
</section>

<!-- BOOKING SECTION -->
<section class="section" id="reservar">
  <div class="container">
    <div class="section-eyebrow">Reserva tu barbacoa</div>
    <h2 class="section-title">Elige tu <span>paquete</span></h2>
    <div class="divider"></div>

    <div class="booking-layout">
      <!-- LEFT -->
      <div>
        <!-- Packages -->
        <div class="packages">

          <div class="pkg-card" onclick="selectPkg(this,1,'Paquete Pequeña — Hasta 20 personas',200)">
            <div class="pkg-icon">🍗</div>
            <div class="pkg-name">Pequeña</div>
            <div class="pkg-guests">Hasta 20 personas</div>
            <div class="pkg-price">200€ <small>/ evento</small></div>
            <div class="pkg-note">🤝 Espacio compartido con otros grupos</div>
            <div class="pkg-check">✓</div>
          </div>

          <div class="pkg-card" onclick="selectPkg(this,2,'Paquete Mediana — Hasta 40 personas',350)">
            <div class="pkg-badge">Más popular</div>
            <div class="pkg-icon">🥩</div>
            <div class="pkg-name">Mediana</div>
            <div class="pkg-guests">Hasta 40 personas</div>
            <div class="pkg-price">350€ <small>/ evento</small></div>
            <div class="pkg-note">🤝 Espacio compartido con otro grupo</div>
            <div class="pkg-check">✓</div>
          </div>

          <div class="pkg-card" onclick="selectPkg(this,3,'Paquete Grande — Hasta 60 personas',400)">
            <div class="pkg-icon">🍖</div>
            <div class="pkg-name">Grande</div>
            <div class="pkg-guests">Hasta 60 personas</div>
            <div class="pkg-price">400€ <small>/ evento</small></div>
            <div class="pkg-note" style="color:#6b1f2a; font-weight:600;">⭐ Instalaciones en exclusividad</div>
            <div class="pkg-check">✓</div>
          </div>

        </div>

        <!-- Extras -->
        <div class="extras-section">
          <div class="extras-heading">Añadir extras opcionales</div>
          <div class="extras-grid">

            <div class="extra-item" onclick="toggleExtra(this,'barril','Barril Ámbar 30L',70,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🍺 Barril Ámbar 30L</div>
                <div class="extra-price">70€ · ~120 cañas</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'barril',-1)">−</button>
                  <span class="qty-val" id="qty-barril">1</span>
                  <button class="qty-btn" onclick="chQty(event,'barril',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'vasos','Vasos plástico 50 ud',3,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🥤 Vasos de plástico</div>
                <div class="extra-price">3€ / pack 50 ud</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'vasos',-1)">−</button>
                  <span class="qty-val" id="qty-vasos">1</span>
                  <button class="qty-btn" onclick="chQty(event,'vasos',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'hielo','Hielo ~2kg',2,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🧊 Hielo</div>
                <div class="extra-price">2€ / bolsa ~2kg</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'hielo',-1)">−</button>
                  <span class="qty-val" id="qty-hielo">1</span>
                  <button class="qty-btn" onclick="chQty(event,'hielo',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'carbon','Carbón vegetal 3kg',5,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🪨 Carbón vegetal</div>
                <div class="extra-price">5€ / bolsa 3kg</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'carbon',-1)">−</button>
                  <span class="qty-val" id="qty-carbon">1</span>
                  <button class="qty-btn" onclick="chQty(event,'carbon',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'refrescos','Refrescos',1,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🥤 Refrescos</div>
                <div class="extra-price">1€ / unidad</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'refrescos',-1)">−</button>
                  <span class="qty-val" id="qty-refrescos">1</span>
                  <button class="qty-btn" onclick="chQty(event,'refrescos',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'servilletas','Rollo de servilletas',3,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🧻 Servilletas</div>
                <div class="extra-price">3€ / rollo</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'servilletas',-1)">−</button>
                  <span class="qty-val" id="qty-servilletas">1</span>
                  <button class="qty-btn" onclick="chQty(event,'servilletas',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'platos','Platos plástico 20 ud',2,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">🍽️ Platos de plástico</div>
                <div class="extra-price">2€ / 20 unidades</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'platos',-1)">−</button>
                  <span class="qty-val" id="qty-platos">1</span>
                  <button class="qty-btn" onclick="chQty(event,'platos',1)">+</button>
                </div>
              </div>
            </div>

            <div class="extra-item" onclick="toggleExtra(this,'agua','Botella de agua 1L',1,true)">
              <div class="extra-checkbox"></div>
              <div class="extra-info">
                <div class="extra-name">💧 Agua 1L</div>
                <div class="extra-price">1€ / botella</div>
                <div class="extra-qty" style="display:none">
                  <button class="qty-btn" onclick="chQty(event,'agua',-1)">−</button>
                  <span class="qty-val" id="qty-agua">1</span>
                  <button class="qty-btn" onclick="chQty(event,'agua',1)">+</button>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- SUMMARY -->
      <div>
        <div class="summary-box">
          <div class="summary-header">Resumen del pedido</div>
          <div id="summaryLines">
            <div class="summary-empty">Selecciona un paquete para comenzar</div>
          </div>
          <div id="summaryTotalBlock" style="display:none">
            <div class="summary-total">
              <span class="label">Total</span>
              <span class="amount" id="totalAmt">0€</span>
            </div>
            <div class="fianza-note">+ 50€ fianza reembolsable</div>
          </div>
          <button class="book-btn" id="bookBtn" disabled>
            Solicitar reserva
          </button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MODAL FORMULARIO -->
<div class="modal-overlay" id="modalForm">
  <div class="modal">
    <div class="modal-title">Confirma tu reserva</div>
    <div class="modal-sub">Rellena tus datos para finalizar la solicitud</div>

    <div id="modalSummaryEl" class="modal-summary"></div>

    <div class="fianza-alert">
      <span style="font-size:1.1rem; flex-shrink:0;">⚠️</span>
      <span><strong>Fianza de 50€</strong> — Se requiere el pago de una fianza para confirmar la reserva. Se devuelve íntegramente tras el evento.</span>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Nombre</label>
        <input class="form-input" id="fNombre" type="text" placeholder="Tu nombre">
      </div>
      <div class="form-group">
        <label class="form-label">Apellido</label>
        <input class="form-input" id="fApellido" type="text" placeholder="Tu apellido">
      </div>
    </div>
    <div class="form-group">
      <label class="form-label">Email</label>
      <input class="form-input" id="fEmail" type="email" placeholder="tu@email.com">
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Teléfono</label>
        <input class="form-input" id="fTelefono" type="tel" placeholder="6XX XXX XXX">
      </div>
      <div class="form-group">
        <label class="form-label">Fecha del evento</label>
        <input class="form-input" id="fFecha" type="date">
      </div>
    </div>

    <div class="form-error" id="formError"></div>

    <div class="modal-actions">
      <button class="btn-cancel btn-cerrar-modal">Cancelar</button>
      <button class="btn-confirm" id="btnConfirm" onclick="submitReserva()">Confirmar reserva</button>
    </div>
  </div>
</div>

<!-- MODAL SUCCESS -->
<div class="modal-overlay" id="modalOk">
  <div class="modal success-modal">
    <div class="success-icon">✅</div>
    <div class="success-title">¡Reserva confirmada!</div>
    <p class="success-text">
      Te hemos enviado un email de confirmación con todos los detalles.<br><br>
      Recuerda que se requiere el pago de la <strong>fianza de 50€</strong> para formalizar definitivamente la reserva.<br><br>
      ¡Nos vemos en la barbacoa!
    </p>
    <button class="btn-primary btn-cerrar-modal" style="border:none; cursor:pointer;">Cerrar</button>
  </div>
</div>

<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">Club Deportivo Montecanal</div>
      <p class="footer-desc">Un espacio diseñado para disfrutar con familia y amigos. Reserva tu barbacoa y crea recuerdos inolvidables.</p>
    </div>
    <div>
      <div class="footer-heading">Servicios</div>
      <ul class="footer-links">
        <li><a href="#reservar">Zona Barbacoas</a></li>
        <li><a href="#info">Instalaciones</a></li>
        <li><a href="#">Contacto</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-heading">Horario</div>
      <ul class="footer-links">
        <li><a href="#">12:00 — 20:00 h</a></li>
        <li><a href="#">Política de privacidad</a></li>
        <li><a href="#">Aviso legal</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© 2025 Club Deportivo Montecanal. Todos los derechos reservados.</span>
    <span>Zaragoza, España</span>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
