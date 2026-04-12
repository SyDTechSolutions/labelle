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
        Schema::table('customers', function (Blueprint $table) {
            // Índice para búsquedas por nombre
            $table->index('name', 'idx_customers_name');
            
            // Índice para búsquedas por identificación
            $table->index('identificacion', 'idx_customers_identificacion');
            
            // Índice único compuesto para tipo + identificación
            $table->index(['tipo_identificacion', 'identificacion'], 'idx_customers_tipo_id');
            
            // Índice para búsquedas por email
            $table->index('email', 'idx_customers_email');
            
            // Índice para búsquedas por teléfono
            $table->index('phone', 'idx_customers_phone');
            
            // Índice para localización geográfica
            $table->index(['provincia', 'canton', 'distrito'], 'idx_customers_location');
        });
        
        // Índice para categoría (TEXT requiere longitud limitada - fuera del Schema::table)
        DB::statement('CREATE INDEX idx_customers_category ON customers (category(100))');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('idx_customers_name');
            $table->dropIndex('idx_customers_identificacion');
            $table->dropIndex('idx_customers_tipo_id');
            $table->dropIndex('idx_customers_email');
            $table->dropIndex('idx_customers_phone');
            DB::statement('DROP INDEX idx_customers_category ON customers');
            $table->dropIndex('idx_customers_location');
        });
    }
};
