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
        // Verificar y agregar solo columnas que no existen
        Schema::table('receptors', function (Blueprint $table) {
            // FechaEmisionFactura ya existe en la base de datos
            
            // Agregar columnas FE 4.3 solo si no existen
            if (!Schema::hasColumn('receptors', 'TotalServNoSujeto')) {
                $table->decimal('TotalServNoSujeto', 18, 5)->default(0)
                    ->comment('Total de servicios no sujetos a impuestos (FE 4.3)');
            }
            
            if (!Schema::hasColumn('receptors', 'TotalMercNoSujeta')) {
                $table->decimal('TotalMercNoSujeta', 18, 5)->default(0)
                    ->comment('Total de mercancías no sujetas a impuestos (FE 4.3)');
            }
            
            if (!Schema::hasColumn('receptors', 'TotalNoSujeto')) {
                $table->decimal('TotalNoSujeto', 18, 5)->default(0)
                    ->comment('Total general no sujeto a impuestos (FE 4.3)');
            }
            
            if (!Schema::hasColumn('receptors', 'TotalVentaNeta')) {
                $table->decimal('TotalVentaNeta', 18, 5)->default(0)
                    ->comment('Total de venta neta (FE 4.3)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('receptors', function (Blueprint $table) {
            // Solo eliminar FechaEmisionFactura si fue agregada por esta migración
            // (pero ya existía, así que no la eliminamos)
            
            if (Schema::hasColumn('receptors', 'TotalServNoSujeto')) {
                $table->dropColumn('TotalServNoSujeto');
            }
            if (Schema::hasColumn('receptors', 'TotalMercNoSujeta')) {
                $table->dropColumn('TotalMercNoSujeta');
            }
            if (Schema::hasColumn('receptors', 'TotalNoSujeto')) {
                $table->dropColumn('TotalNoSujeto');
            }
            if (Schema::hasColumn('receptors', 'TotalVentaNeta')) {
                $table->dropColumn('TotalVentaNeta');
            }
        });
    }
};
