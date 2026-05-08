emailjs.init('YOUR_PUBLIC_KEY');

let selPkg = null;
let extras = {};
let qtys = { barril:1, vasos:1, hielo:1, carbon:1, refrescos:1, servilletas:1, platos:1, agua:1 };

/**
 * Selecciona un paquete de barbacoa, actualiza la interfaz de usuario y refresca el resumen.
 * @param {HTMLElement} el - El elemento del paquete seleccionado.
 * @param {number} id - ID del paquete.
 * @param {string} name - Nombre del paquete.
 * @param {number} price - Precio del paquete.
 */
function selectPkg(el, id, name, price) {
  document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
  el.classList.add('selected');
  selPkg = { id, name, price };
  updateSummary();
}

/**
 * Alterna la selección de un extra, actualiza la interfaz y el resumen.
 * @param {HTMLElement} el - El elemento del extra.
 * @param {string} key - Clave del extra.
 * @param {string} name - Nombre del extra.
 * @param {number} price - Precio del extra.
 * @param {boolean} hasQty - Si el extra tiene cantidad.
 */
function toggleExtra(el, key, name, price, hasQty) {
  if (extras[key]) {
    delete extras[key];
    el.classList.remove('selected');
    if (hasQty) el.querySelector('.extra-qty').style.display = 'none';
  } else {
    extras[key] = { name, price, hasQty };
    el.classList.add('selected');
    if (hasQty) el.querySelector('.extra-qty').style.display = 'flex';
  }
  updateSummary();
}

/**
 * Cambia la cantidad de un extra.
 * @param {Event} e - El evento del clic.
 * @param {string} key - Clave del extra.
 * @param {number} d - Cambio en la cantidad (positivo o negativo).
 */
function chQty(e, key, d) {
  e.stopPropagation();
  qtys[key] = Math.max(1, (qtys[key] || 1) + d);
  document.getElementById('qty-' + key).textContent = qtys[key];
  updateSummary();
}

/**
 * Calcula el total del precio incluyendo paquete y extras.
 * @returns {number} El total calculado.
 */
function calcTotal() {
  if (!selPkg) return 0;
  let t = selPkg.price;
  for (const [k, ex] of Object.entries(extras)) t += ex.price * (ex.hasQty ? qtys[k] || 1 : 1);
  return t;
}

/**
 * Actualiza la visualización del resumen de la reserva.
 */
function updateSummary() {
  const linesEl = document.getElementById('summaryLines');
  const totalBlock = document.getElementById('summaryTotalBlock');
  const btn = document.getElementById('bookBtn');

  if (!selPkg) {
    linesEl.innerHTML = '<div class="summary-empty">Selecciona un paquete para comenzar</div>';
    totalBlock.style.display = 'none';
    btn.disabled = true;
    return;
  }

  let html = `<div class="summary-line"><span class="name">${selPkg.name}</span><span class="price">${selPkg.price}€</span></div>`;
  for (const [k, ex] of Object.entries(extras)) {
    const qty = ex.hasQty ? qtys[k] || 1 : 1;
    html += `<div class="summary-line"><span class="name">${ex.name}${qty > 1 ? ' ×'+qty : ''}</span><span class="price">${ex.price * qty}€</span></div>`;
  }

  linesEl.innerHTML = html;
  document.getElementById('totalAmt').textContent = calcTotal() + '€';
  totalBlock.style.display = 'block';
  btn.disabled = false;
}

/**
 * Abre el modal de confirmación con el resumen de la reserva.
 */
function openModal() {
  let html = '';
  if (selPkg) html += `<strong>${selPkg.name}</strong> — ${selPkg.price}€<br>`;
  for (const [k, ex] of Object.entries(extras)) {
    const qty = ex.hasQty ? qtys[k] || 1 : 1;
    html += `· ${ex.name}${qty>1?' ×'+qty:''} — ${ex.price*qty}€<br>`;
  }
  html += `<strong style="color:var(--burgundy)">Total: ${calcTotal()}€ + 50€ fianza</strong>`;
  document.getElementById('modalSummaryEl').innerHTML = html;
  document.getElementById('modalForm').classList.add('active');
}

/**
 * Cierra el modal del formulario, opcionalmente resetea todo.
 * @param {boolean} clear - Si se debe resetear todo.
 */
function closeModalForm(clear) {
  document.getElementById('modalForm').classList.remove('active');
  document.getElementById('formError').style.display = 'none';
  document.getElementById('btnConfirm').disabled = false;
  document.getElementById('btnConfirm').textContent = 'Confirmar reserva';
  if (clear) resetAll();
}

/**
 * Cierra el modal de éxito y resetea todo.
 */
function closeModalOk() {
  document.getElementById('modalOk').classList.remove('active');
  resetAll();
}

/**
 * Resetea todas las selecciones, extras y campos del formulario.
 */
function resetAll() {
  document.querySelectorAll('.pkg-card').forEach(c => c.classList.remove('selected'));
  document.querySelectorAll('.extra-item').forEach(c => c.classList.remove('selected'));
  document.querySelectorAll('.extra-qty').forEach(q => q.style.display = 'none');
  selPkg = null; extras = {};
  qtys = { barril:1,vasos:1,hielo:1,carbon:1,refrescos:1,servilletas:1,platos:1,agua:1 };
  Object.keys(qtys).forEach(k => { const el = document.getElementById('qty-'+k); if(el) el.textContent=1; });
  ['fNombre','fApellido','fEmail','fTelefono','fFecha'].forEach(id => document.getElementById(id).value='');
  updateSummary();
}

async function submitReserva() {
  const n = document.getElementById('fNombre').value.trim();
  const a = document.getElementById('fApellido').value.trim();
  const e = document.getElementById('fEmail').value.trim();
  const t = document.getElementById('fTelefono').value.trim();
  const f = document.getElementById('fFecha').value;
  const errEl = document.getElementById('formError');

  // 1. Validaciones básicas del lado del cliente
  if (!n||!a||!e||!t||!f) { errEl.textContent='Por favor, rellena todos los campos.'; errEl.style.display='block'; return; }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(e)) { errEl.textContent='El email no tiene un formato válido.'; errEl.style.display='block'; return; }
  
  const fechaSeleccionada = new Date(f);
  const fechaHoy = new Date();
  fechaHoy.setHours(0,0,0,0);
  if (fechaSeleccionada <= fechaHoy) { errEl.textContent = 'La fecha del evento debe ser a partir de mañana.'; errEl.style.display = 'block'; return; }

  // 2. Validación de reCAPTCHA (¡ANTES de bloquear el botón!)
  const recaptchaResponse = grecaptcha.getResponse();
  if (recaptchaResponse.length === 0) {
    errEl.textContent = 'Por favor, verifica que no eres un robot marcando la casilla.'; 
    errEl.style.display = 'block'; 
    return; 
  }

  // Si pasamos todas las validaciones, ocultamos errores y bloqueamos el botón
  errEl.style.display='none';
  const btn = document.getElementById('btnConfirm');
  btn.textContent = 'Enviando...'; 
  btn.disabled = true;

  // 3. Diccionario traductor para la Base de Datos
  const mapaExtras = {
    'barril': 1, 'vasos': 2, 'hielo': 3, 'carbon': 4,
    'refrescos': 5, 'servilletas': 6, 'platos': 7, 'agua': 8
  };

  // 4. Preparamos el paquete de datos estructurado para Laravel
  const datosReserva = {
    paquete_id: selPkg.id,
    nombre: n,
    apellido: a,
    email: e,
    telefono: t,
    fecha_evento: f,
    extras: Object.entries(extras).map(([key, ex]) => ({
      id: mapaExtras[key],
      cantidad: ex.hasQty ? qtys[key] || 1 : 1
    })),
    recaptcha_token: recaptchaResponse // <-- Ahora el token se inyecta correctamente
  };

  // 5. Conexión segura con el Backend
  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const response = await fetch('/api/reservar', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken
      },
      body: JSON.stringify(datosReserva)
    });

    const result = await response.json();

    if (result.success) {
      closeModalForm(false);
      document.getElementById('modalOk').classList.add('active');
    } else {
      // Si Laravel o Google rechazan la validación en el servidor
      throw new Error(result.message || 'Error desconocido en el servidor');
    }
    
  } catch(err) {
    errEl.textContent = err.message || '⚠️ Error en la conexión con el servidor. Revisa la consola.';
    errEl.style.display = 'block';
    console.error("Detalles del error:", err);
    
    // Devolvemos el botón a su estado normal para que puedan reintentar
    btn.textContent = 'Confirmar reserva'; 
    btn.disabled = false;
    
    // Reseteamos la casilla de Google para que puedan volver a verificarla
    grecaptcha.reset(); 
  }
}

/**
   * ==========================================
   * SISTEMA GENÉRICO DE GESTIÓN DE MODALES
   * ==========================================
   * Este script permite abrir y cerrar cualquier modal de la página
   * sin necesidad de crear funciones individuales para cada uno.
   * 
   * Requisitos en el HTML:
   * - Botones para abrir: class="btn-abrir-modal" y atributo data-target="idDelModal"
   * - Botones para cerrar: class="btn-cerrar-modal"
   * - Contenedor del modal: class="modal-overlay" y un ID único
   */

  // --- 1. LÓGICA PARA ABRIR MODALES ---

  // Seleccionamos todos los botones que tengan la misión de abrir un modal
  const botonesAbrir = document.querySelectorAll('.btn-abrir-modal');

  // Recorremos la lista de botones encontrados
  botonesAbrir.forEach(boton => {
    // A cada botón le añadimos un escuchador de eventos para el 'clic'
    boton.addEventListener('click', function() {
      
      // 'this' hace referencia al botón exacto que el usuario acaba de pulsar.
      // Leemos su atributo 'data-target' para saber qué modal quiere abrir.
      const idDelModal = this.getAttribute('data-target');
      
      // Buscamos en el documento el modal que coincida con ese ID
      const modalCorrecto = document.getElementById(idDelModal);
      
      // Si el modal existe en el HTML, lo mostramos añadiéndole la clase 'active'
      if (modalCorrecto) {
        modalCorrecto.classList.add('active');
      }
      
    });
  });


  // --- 2. LÓGICA PARA CERRAR MODALES ---

  // Seleccionamos todos los botones (como las 'X' o 'Cancelar') destinados a cerrar
  const botonesCerrar = document.querySelectorAll('.btn-cerrar-modal');

  // Recorremos la lista de botones de cierre
  botonesCerrar.forEach(boton => {
    // Les añadimos el escuchador del clic
    boton.addEventListener('click', function() {
      
      // Usamos .closest() para buscar "hacia arriba" en el HTML.
      // El botón busca a su contenedor padre más cercano que sea un modal.
      // Así, el botón no necesita saber cómo se llama el modal en el que está.
      const modalPadre = this.closest('.modal-overlay');
      
      // Si encontramos el contenedor padre, lo ocultamos quitando la clase 'active'
      if (modalPadre) {
        modalPadre.classList.remove('active');
      }
      
    });
  });

  // --- LÓGICA ESPECÍFICA PARA EL BOTÓN DE RESERVA  ---
const botonReserva = document.getElementById('bookBtn');

if (botonReserva) {
  // Cuando hagan clic, ejecutamos la función que prepara los datos y abre el modal
  botonReserva.addEventListener('click', openModal);
}
// Establece el día de mañana como fecha mínima en el calendario HTML
const mañana = new Date();
mañana.setDate(mañana.getDate() + 1);
document.getElementById('fFecha').min = mañana.toISOString().split("T")[0];
