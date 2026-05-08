# 🥩 Sistema de Reservas - CD Montecanal

Aplicación web Full-Stack asíncrona para la gestión de reservas de las zonas de barbacoa del Club Deportivo Montecanal, diseñada con un fuerte enfoque en la seguridad, la integridad de los datos y la experiencia del usuario (UX).

## 🚀 Características Principales
* **Reserva dinámica:** Selección de paquetes (Pequeña, Mediana, Grande) con cálculo de precios en tiempo real mediante JavaScript.
* **Gestión de Extras:** Posibilidad de añadir extras con cantidades personalizables (Barril de cerveza, hielo, carbón, etc.).
* **Sistema de Notificaciones Asíncrono:** Envío de correos electrónicos transaccionales con diseño corporativo (Markdown Mailables) gestionados en segundo plano mediante **Laravel Queues** para no bloquear la experiencia del usuario.
* **Autogestión Segura de Reservas:** Sistema de cancelación mediante **Rutas Firmadas Criptográficamente (Signed Routes)** que previenen vulnerabilidades IDOR (Insecure Direct Object Reference) y garantizan la integridad de la petición.
* **Arquitectura MVC:** Separación estricta entre la lógica de negocio (Controladores), la interfaz de usuario (Vistas Blade) y la base de datos (Modelos).
* **Seguridad y Defensa en Profundidad Integrada:**
  * **Mitigación de Bots (Capa 7):** Integración de Google reCAPTCHA v2 validado bidireccionalmente (Frontend y consulta HTTP en el Backend).
  * **Validación Estricta:** Motor de validación en el servidor que rechaza datos corruptos y bloquea fechas pasadas (`after:today`).
  * **Integridad Transaccional:** Recálculo de precios directamente desde la base de datos para anular cualquier manipulación en el frontend.
  * **Protección CSRF:** Uso de tokens de sesión para blindar los formularios contra peticiones falsificadas.

## 🛠️ Tecnologías Utilizadas
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla - Fetch API)
* **Backend:** PHP 8, Laravel 11 (Routing, Eloquent ORM, Mail, Queues, HTTP Client)
* **Base de Datos:** MySQL (Diseño relacional con tablas pivote)
* **Integraciones de Terceros:** * API de Google reCAPTCHA v2
  * Mailtrap (Entorno SMTP aislado para pruebas de correo)

## ⚙️ Estructura de la Base de Datos
El proyecto cuenta con un diseño de base de datos relacional preparado para escalar:
* `paquetes`: Información y precios base de las instalaciones.
* `extras`: Catálogo de productos adicionales.
* `reservas`: Información del cliente, fecha del evento y **gestión de estados** (pendiente, cancelada).
* `extra_reserva`: Tabla pivote (Muchos a Muchos) que almacena el precio unitario histórico (snapshot) y las cantidades exactas de cada pedido.
* `jobs`: Tabla del sistema de Laravel para la gestión encolada de correos electrónicos.

## 💻 Instalación en Entorno Local

1. Clonar el repositorio: `git clone https://github.com/TU_USUARIO/TU_REPO.git`
2. Instalar dependencias: `composer install`
3. Crear una copia del archivo de entorno: `cp .env.example .env`
4. Generar la clave de encriptación de la aplicación: `php artisan key:generate`
5. Configurar la conexión a la base de datos en el archivo `.env`.
6. Configurar las credenciales de servicios externos en el `.env`:
   ```env
   # Configuración de Mailtrap
   MAIL_MAILER=smtp
   MAIL_HOST=sandbox.smtp.mailtrap.io
   MAIL_PORT=2525
   MAIL_USERNAME=tu_usuario
   MAIL_PASSWORD=tu_password

   # Configuración de Google reCAPTCHA v2
   RECAPTCHA_SITE_KEY=tu_clave_publica
   RECAPTCHA_SECRET_KEY=tu_clave_privada