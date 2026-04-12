<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCreatedByToProformasPurchasesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->unsignedInteger('created_by')->default(0)->index();
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->unsignedInteger('created_by')->default(0)->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proformas', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
        Schema::table('purchases', function (Blueprint $table) {
            $table->dropColumn('created_by');
        });
    }
}
