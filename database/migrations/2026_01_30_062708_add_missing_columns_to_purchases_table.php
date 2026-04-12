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
        // La columna observations ya existe en la tabla purchases
        // No se requiere ninguna modificación
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No hay columnas que eliminar
    }
};
