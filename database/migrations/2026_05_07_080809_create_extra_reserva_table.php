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
    Schema::create('extra_reserva', function (Blueprint $table) {
        $table->id();
        
        // Claves foráneas (si se borra la reserva, se borran sus extras en cascada)
        $table->foreignId('reserva_id')->constrained('reservas')->onDelete('cascade');
        $table->foreignId('extra_id')->constrained('extras')->onDelete('restrict');
        
        // Datos de la compra
        $table->integer('cantidad')->default(1);
        $table->decimal('precio_unitario', 8, 2); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extra_reserva');
    }
};
