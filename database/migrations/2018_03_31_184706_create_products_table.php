<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->index();
            $table->string('location')->nullable();
            $table->string('code');
            $table->string('name');
            $table->decimal('quantity', 8, 2)->default(0);
            $table->decimal('subquantity', 8, 2)->default(1);
            $table->double('price');
            $table->double('priceWithTaxes')->default(0);
            $table->double('taxesAmount')->default(0);
            $table->double('purchase_price')->default(0);
            $table->decimal('utilidad', 6, 2)->default(0);
            $table->tinyInteger('exo')->default(0);
            $table->string('measure');
            $table->integer('max')->default(0);
            $table->integer('min')->default(0);
            $table->text('observations')->nullable();
            $table->string('photo_path')->nullable();
            $table->char('type', 2)->default('P'); //Producto o Servicio
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
