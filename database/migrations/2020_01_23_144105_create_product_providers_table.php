<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('created_by')->default(0)->index();
            $table->timestamps();
        });

        Schema::create('product_provider_lines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_provider_id')->index();
            $table->string('Codigo');
            $table->string('Detalle');
            $table->decimal('Cantidad', 16, 3)->default(0);
            $table->decimal('PrecioUnitario', 18, 5)->default(0);
            $table->longText('providers');
            $table->timestamps();

            $table->foreign('product_provider_id')
                    ->references('id')
                    ->on('product_providers')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_provider_lines');
        Schema::dropIfExists('product_providers');
    }
}
