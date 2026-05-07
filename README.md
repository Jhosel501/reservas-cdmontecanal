# 🥩 Sistema de Reservas - CD Montecanal

Aplicación web Full-Stack para la gestión de reservas de las zonas de barbacoa del Club Deportivo Montecanal. 

## 🚀 Características Principales
* **Reserva dinámica:** Selección de paquetes (Pequeña, Mediana, Grande) con cálculo de precios en tiempo real.
* **Gestión de Extras:** Posibilidad de añadir extras con cantidades personalizables (Barril de cerveza, hielo, carbón, etc.).
* **Arquitectura MVC:** Separación estricta entre la lógica de negocio (Controladores), la interfaz de usuario (Vistas Blade) y la base de datos (Modelos).
* **Seguridad Integrada:**
  * Validación estricta de datos en el servidor (Backend).
  * Recálculo de precios desde la base de datos para evitar manipulaciones en el frontend.
  * Protección total contra ataques CSRF mediante tokens de sesión.

## 🛠️ Tecnologías Utilizadas
* **Frontend:** HTML5, CSS3, JavaScript (Vanilla - Fetch API)
* **Backend:** PHP 8, Laravel 11
* **Base de Datos:** MySQL (Diseño relacional con tablas pivote)

## ⚙️ Estructura de la Base de Datos
El proyecto cuenta con un diseño de base de datos relacional preparado para escalar:
* `paquetes`: Información y precios base de las instalaciones.
* `extras`: Catálogo de productos adicionales.
* `reservas`: Información del cliente y fecha del evento.
* `extra_reserva`: Tabla pivote (Muchos a Muchos) que almacena el precio unitario histórico y las cantidades exactas de cada pedido.

## 💻 Instalación en Entorno Local
1. Clonar el repositorio: `git clone https://github.com/TU_USUARIO/TU_REPO.git`
2. Instalar dependencias: `composer install`
3. Crear una copia del archivo `.env`: `cp .env.example .env`
4. Generar la clave de la aplicación: `php artisan key:generate`
5. Configurar la base de datos en el archivo `.env`.
6. Ejecutar las migraciones y seeders: `php artisan migrate --seed`
7. Levantar el servidor: `php artisan serve`