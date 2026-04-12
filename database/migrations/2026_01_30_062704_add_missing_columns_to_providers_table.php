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
        Schema::table('providers', function (Blueprint $table) {
            // Campos de ubicación geográfica para Costa Rica
            $table->char('provincia', 1)->default('1')->after('email')
                ->comment('Código de provincia (1-7)');
            
            $table->char('canton', 2)->default('01')->after('provincia')
                ->comment('Código de cantón');
            
            $table->char('distrito', 2)->nullable()->after('canton')
                ->comment('Código de distrito');
            
            $table->char('barrio', 2)->nullable()->after('distrito')
                ->comment('Código de barrio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn(['provincia', 'canton', 'distrito', 'barrio']);
        });
    }
};
