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
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('restaurante_id');
            $table->foreign('restaurante_id')->references('id_restaurante')->on('restaurantes')->onDelete('cascade');
            $table->unsignedBigInteger('mesa_id')->nullable();
            $table->foreign('mesa_id')->references('id')->on('mesas')->onDelete('set null');
            $table->dateTime('fecha');
            $table->time('hora'); // Columna 'hora' definida en su posición correcta
            $table->integer('num_personas');
            $table->decimal('importe_reserva', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservas');
        Schema::dropIfExists('mesas');
    }
};
