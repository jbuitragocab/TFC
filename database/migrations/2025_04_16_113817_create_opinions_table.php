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
        Schema::create('opiniones', function (Blueprint $table) {
            $table->id('id_opinion');
            $table->unsignedBigInteger('usuario_id');
            $table->unsignedBigInteger('restaurante_id');
            $table->text('comentario');
            $table->unsignedTinyInteger('calificacion');
            $table->date('fecha');
            $table->timestamps();

            $table->foreign('usuario_id')->references('id_usuario')->on('users')->onDelete('cascade');
            $table->foreign('restaurante_id')->references('id_restaurante')->on('restaurantes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opinions');
    }
};
