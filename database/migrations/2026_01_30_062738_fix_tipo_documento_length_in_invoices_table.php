<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Cambiar TipoDocumento de char(1) a char(191) para compatibilidad con BD producci\u00f3n
            DB::statement('ALTER TABLE invoices MODIFY TipoDocumento CHAR(191) NOT NULL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Revertir a char(1)
            DB::statement('ALTER TABLE invoices MODIFY TipoDocumento CHAR(1) NOT NULL');
        });
    }
};
