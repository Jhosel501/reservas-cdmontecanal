<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('reservas', function (Blueprint $table) {
        $table->id();
        
        // Clave foránea al paquete
        $table->foreignId('paquete_id')->constrained('paquetes')->onDelete('restrict');
        
        // Datos del cliente
        $table->string('nombre_cliente');
        $table->string('apellido_cliente');
        $table->string('email_cliente');
        $table->string('telefono_cliente');
        
        // Datos de la reserva
        $table->date('fecha_evento');
        $table->string('estado')->default('pendiente'); 
        $table->decimal('total_calculado', 8, 2); 
        $table->text('notas_admin')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};
