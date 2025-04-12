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
            $table->id('id_reserva');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('restaurante_id');
            $table->date('fecha');
            $table->integer('num_personas');
            $table->decimal('importe_reserva', 8, 2);
            $table->timestamps();

            $table->foreign('usuario_id')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->foreign('restaurante_id')->references('id_restaurante')->on('restaurantes')->onDelete('cascade');
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
