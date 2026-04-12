<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProvinciaCantonDistritoToCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->char('provincia', 1)->nullable();
            $table->char('canton', 2)->nullable();
            $table->char('distrito', 2)->nullable();
            $table->char('barrio', 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('provincia');
            $table->dropColumn('canton');
            $table->dropColumn('distrito');
            $table->dropColumn('barrio');
        });
    }
}
