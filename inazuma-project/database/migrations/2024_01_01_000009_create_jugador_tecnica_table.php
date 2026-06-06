<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jugador_tecnica', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jugador');
            $table->unsignedBigInteger('id_tecnica');

            $table->primary(['id_jugador', 'id_tecnica']);

            $table->foreign('id_jugador')
                  ->references('id')
                  ->on('jugadores')
                  ->onDelete('cascade');

            $table->foreign('id_tecnica')
                  ->references('id')
                  ->on('tecnicas')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jugador_tecnica');
    }
};
