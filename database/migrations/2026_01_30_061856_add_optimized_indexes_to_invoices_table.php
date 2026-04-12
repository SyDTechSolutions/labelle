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
            // Índices para búsquedas por cliente
            $table->index('customer_id', 'idx_invoices_customer');
            
            // Índices para filtros por fechas y created_at
            $table->index('created_at', 'idx_invoices_created_at');
            $table->index(['created_at', 'status'], 'idx_invoices_created_status');
            
            // Índices para búsquedas por consecutivo y clave FE
            $table->index('consecutivo', 'idx_invoices_consecutivo');
            $table->index('clave_fe', 'idx_invoices_clave_fe');
            $table->index('NumeroConsecutivo', 'idx_invoices_num_consecutivo');
            
            // Índices para filtros por estado
            $table->index('status', 'idx_invoices_status');
            $table->index('canceled', 'idx_invoices_canceled');
            $table->index(['status', 'canceled'], 'idx_invoices_status_canceled');
            
            // Índices para facturación electrónica
            $table->index('sent_to_hacienda', 'idx_invoices_sent_hacienda');
            $table->index('status_fe', 'idx_invoices_status_fe');
            $table->index(['fe', 'status_fe'], 'idx_invoices_fe_status');
            
            // Índice para búsquedas por usuario creador
            $table->index('created_by', 'idx_invoices_created_by');
            
            // Índice compuesto para reportes (fecha + estado + tipo documento)
            $table->index(['created_at', 'TipoDocumento', 'status'], 'idx_invoices_reports');
            
            // Índice para CXC - cuentas por cobrar
            $table->index(['CondicionVenta', 'cxc_pending_amount'], 'idx_invoices_cxc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropIndex('idx_invoices_customer');
            $table->dropIndex('idx_invoices_created_at');
            $table->dropIndex('idx_invoices_created_status');
            $table->dropIndex('idx_invoices_consecutivo');
            $table->dropIndex('idx_invoices_clave_fe');
            $table->dropIndex('idx_invoices_num_consecutivo');
            $table->dropIndex('idx_invoices_status');
            $table->dropIndex('idx_invoices_canceled');
            $table->dropIndex('idx_invoices_status_canceled');
            $table->dropIndex('idx_invoices_sent_hacienda');
            $table->dropIndex('idx_invoices_status_fe');
            $table->dropIndex('idx_invoices_fe_status');
            $table->dropIndex('idx_invoices_created_by');
            $table->dropIndex('idx_invoices_reports');
            $table->dropIndex('idx_invoices_cxc');
        });
    }
};
