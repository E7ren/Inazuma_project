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
        Schema::create('jugadores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->string('imagen_url', 255)->nullable();
            $table->unsignedBigInteger('id_elemento')->nullable();
            $table->unsignedBigInteger('id_equipo')->nullable();
            
            $table->foreign('id_elemento')
                  ->references('id')
                  ->on('elementos')
                  ->onDelete('restrict');
                  
            $table->foreign('id_equipo')
                  ->references('id')
                  ->on('equipos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jugadores');
    }
};
