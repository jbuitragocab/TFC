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

            // FK a users
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');

            // FK a restaurantes
            $table->unsignedBigInteger('restaurante_id');
            $table->foreign('restaurante_id')->references('id_restaurante')->on('restaurantes')->onDelete('cascade');

            // Fecha y datos de reserva
            $table->dateTime('fecha');
            $table->integer('num_personas');

            // **Nueva columna mesa_id FK a mesas.id
            $table->unsignedBigInteger('mesa_id');
            $table->foreign('mesa_id')->references('id')->on('mesas')->onDelete('restrict');

            $table->decimal('importe_reserva', 8, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservas', function (Blueprint $table) {
            $table->dropForeign(['mesa_id']);
            $table->dropColumn('mesa_id');
        });

        Schema::dropIfExists('reservas');
    }
};
