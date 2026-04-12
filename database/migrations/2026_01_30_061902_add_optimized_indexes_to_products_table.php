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
        Schema::table('products', function (Blueprint $table) {
            // Índice único para código de producto
            $table->unique('code', 'unique_products_code');
            
            // Índice para búsquedas por nombre
            $table->index('name', 'idx_products_name');
            
            // Índice para gestión de inventario (quantity = stock)
            $table->index('quantity', 'idx_products_quantity');
            $table->index(['quantity', 'min'], 'idx_products_stock_alert');
            
            // Índice para precio
            $table->index('price', 'idx_products_price');
            
            // Índice para tipo de producto (P=Producto, S=Servicio)
            $table->index('type', 'idx_products_type');
            
            // Índice para proveedor
            // provider_id ya tiene índice en create_products_table
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropUnique('unique_products_code');
            $table->dropIndex('idx_products_name');
            $table->dropIndex('idx_products_quantity');
            $table->dropIndex('idx_products_stock_alert');
            $table->dropIndex('idx_products_price');
            $table->dropIndex('idx_products_type');
        });
    }
};
