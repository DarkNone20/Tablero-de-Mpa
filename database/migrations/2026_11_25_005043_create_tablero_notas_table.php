<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tablero_notas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo')->nullable();
            $table->text('contenido');
            $table->enum('tipo', ['general', 'fecha'])->default('fecha');
            $table->date('fecha')->nullable(); // Solo se llena si tipo == 'fecha'
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tablero_notas');
    }
};