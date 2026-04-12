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
        Schema::table('invoices', function (Blueprint $table) {
            // Campos para Factura Electrónica versión 4.3
            $table->string('CodigoActividad', 45)->nullable()
                ->comment('Código de actividad económica del emisor');
            
            
            $table->string('CodigoActividadReceptor', 45)->nullable()
                ->comment('Código de actividad económica del receptor (FE 4.3)');
            
            $table->decimal('TotalServNoSujeto', 18, 5)->default(0)
                ->comment('Total de servicios no sujetos a impuestos (FE 4.3)');
            
            $table->decimal('TotalMercNoSujeta', 18, 5)->default(0)
                ->comment('Total de mercancías no sujetas a impuestos (FE 4.3)');
            
            $table->decimal('TotalNoSujeto', 18, 5)->default(0)
                ->comment('Total general no sujeto a impuestos (FE 4.3)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn([
                'CodigoActividad',
                'CodigoActividadReceptor',
                'TotalServNoSujeto',
                'TotalMercNoSujeta',
                'TotalNoSujeto'
            ]);
        });
    }
};
