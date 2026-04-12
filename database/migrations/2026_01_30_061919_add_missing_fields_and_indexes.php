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
        // Agregar índices a tabla payments
        Schema::table('payments', function (Blueprint $table) {
            $table->index('invoice_id', 'idx_payments_invoice');
            $table->index('date', 'idx_payments_date');
            $table->index(['invoice_id', 'date'], 'idx_payments_invoice_date');
        });
        
        // Agregar índices a tabla purchase_payments
        if (Schema::hasTable('purchase_payments')) {
            Schema::table('purchase_payments', function (Blueprint $table) {
                $table->index('purchase_id', 'idx_purchase_payments_purchase');
                $table->index('date', 'idx_purchase_payments_date');
            });
        }
        
        // Agregar índices a tabla purchases
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->index('provider_id', 'idx_purchases_provider');
                $table->index('created_at', 'idx_purchases_created_at');
                $table->index('status', 'idx_purchases_status');
                $table->index(['created_at', 'status'], 'idx_purchases_created_status');
            });
        }
        
        // Agregar índices a tabla providers
        if (Schema::hasTable('providers')) {
            Schema::table('providers', function (Blueprint $table) {
                $table->index('name', 'idx_providers_name');
                $table->index('dni', 'idx_providers_dni');
                $table->index('email', 'idx_providers_email');
            });
        }
        
        // Agregar índices a tabla expenses
        Schema::table('expenses', function (Blueprint $table) {
            $table->index('date', 'idx_expenses_date');
            $table->index('fromCierre', 'idx_expenses_from_cierre');
            $table->index(['date', 'fromCierre'], 'idx_expenses_date_cierre');
        });
        
        // Nota: users no tiene role_id, la relación es users->status
        // email ya tiene índice único en la migración create_users_table
        
        // Agregar índices a tabla product_providers
        // Nota: product_providers solo tiene id, created_by, created_at, updated_at
        // No tiene provider_id, created_by ya tiene índice desde migración original
        if (Schema::hasTable('product_providers')) {
            Schema::table('product_providers', function (Blueprint $table) {
                $table->index('created_at', 'idx_product_providers_created_at');
            });
        }
        
        // Agregar índices a tabla proformas
        if (Schema::hasTable('proformas')) {
            Schema::table('proformas', function (Blueprint $table) {
                $table->index('customer_id', 'idx_proformas_customer');
                $table->index('created_at', 'idx_proformas_created_at');
                $table->index('status', 'idx_proformas_status');
            });
        }
        
        // Agregar índices a tabla cajas
        Schema::table('cajas', function (Blueprint $table) {
            $table->index('created_at', 'idx_cajas_created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropIndex('idx_payments_invoice');
            $table->dropIndex('idx_payments_date');
            $table->dropIndex('idx_payments_invoice_date');
        });
        
        if (Schema::hasTable('purchase_payments')) {
            Schema::table('purchase_payments', function (Blueprint $table) {
                $table->dropIndex('idx_purchase_payments_purchase');
                $table->dropIndex('idx_purchase_payments_date');
            });
        }
        
        if (Schema::hasTable('purchases')) {
            Schema::table('purchases', function (Blueprint $table) {
                $table->dropIndex('idx_purchases_provider');
                $table->dropIndex('idx_purchases_created_at');
                $table->dropIndex('idx_purchases_status');
                $table->dropIndex('idx_purchases_created_status');
            });
        }
        
        if (Schema::hasTable('providers')) {
            Schema::table('providers', function (Blueprint $table) {
                $table->dropIndex('idx_providers_name');
                $table->dropIndex('idx_providers_dni');
                $table->dropIndex('idx_providers_email');
            });
        }
        
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropIndex('idx_expenses_date');
            $table->dropIndex('idx_expenses_from_cierre');
            $table->dropIndex('idx_expenses_date_cierre');
        });
        
        // Nota: users no tiene role_id
        // Nota: product_providers solo tiene created_by con índice
        
        if (Schema::hasTable('product_providers')) {
            Schema::table('product_providers', function (Blueprint $table) {
                $table->dropIndex('idx_product_providers_created_at');
            });
        }
        
        if (Schema::hasTable('proformas')) {
            Schema::table('proformas', function (Blueprint $table) {
                $table->dropIndex('idx_proformas_customer');
                $table->dropIndex('idx_proformas_created_at');
                $table->dropIndex('idx_proformas_status');
            });
        }
        
        Schema::table('cajas', function (Blueprint $table) {
            $table->dropIndex('idx_cajas_created_at');
        });
    }
};
