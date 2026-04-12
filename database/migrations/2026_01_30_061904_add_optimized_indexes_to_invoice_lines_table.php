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
        Schema::table('invoice_lines', function (Blueprint $table) {
            // Índice para relación con facturas
            $table->index('invoice_id', 'idx_invoice_lines_invoice');
            
            // Índice para búsquedas por código de producto
            $table->index('Codigo', 'idx_invoice_lines_codigo');
            
            // Índice compuesto para joins y reportes
            $table->index(['invoice_id', 'Codigo'], 'idx_invoice_lines_invoice_codigo');
            
            // Índice para fechas (usado en reportes de ventas)
            $table->index('created_at', 'idx_invoice_lines_created_at');
            
            // Índice para tipo de línea (producto o servicio)
            $table->index('type', 'idx_invoice_lines_type');
            
            // Índice para líneas que actualizan stock
            $table->index('updateStock', 'idx_invoice_lines_update_stock');
            
            // Índice compuesto para análisis de ventas por producto y fecha
            $table->index(['Codigo', 'created_at'], 'idx_invoice_lines_product_sales');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_lines', function (Blueprint $table) {
            $table->dropIndex('idx_invoice_lines_invoice');
            $table->dropIndex('idx_invoice_lines_codigo');
            $table->dropIndex('idx_invoice_lines_invoice_codigo');
            $table->dropIndex('idx_invoice_lines_created_at');
            $table->dropIndex('idx_invoice_lines_type');
            $table->dropIndex('idx_invoice_lines_update_stock');
            $table->dropIndex('idx_invoice_lines_product_sales');
        });
    }
};
