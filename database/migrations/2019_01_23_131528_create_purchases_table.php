<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('provider_id')->index();
            $table->integer('consecutivo');
            $table->string('tipo_identificacion_cliente')->nullable();
            $table->string('identificacion_cliente')->nullable();
            $table->string('cliente')->nullable();
            $table->string('email')->nullable();
            $table->char('TipoDocumento')->default('01'); //
            $table->char('MedioPago', 2)->default('01');
            $table->char('CondicionVenta', 2)->default('01');
            $table->string('PlazoCredito')->nullable();
            $table->char('CodigoMoneda', 3)->default('CRC'); //
            $table->decimal('TipoCambio', 18, 5)->default(1);
            $table->decimal('TotalServGravados', 18, 5)->default(0);
            $table->decimal('TotalServExentos', 18, 5)->default(0);
            $table->decimal('TotalMercanciasGravadas', 18, 5)->default(0);
            $table->decimal('TotalMercanciasExentas', 18, 5)->default(0);
            $table->decimal('TotalGravado', 18, 5)->default(0);
            $table->decimal('TotalExento', 18, 5)->default(0);
            $table->decimal('TotalVenta', 18, 5)->default(0);
            $table->decimal('TotalDescuentos', 18, 5)->default(0);
            $table->decimal('TotalVentaNeta', 18, 5)->default(0);
            $table->decimal('TotalImpuesto', 18, 5)->default(0);
            $table->decimal('TotalComprobante', 18, 5)->default(0);
            $table->decimal('TotalWithNota', 18, 5)->default(0);
            $table->decimal('pay_with', 18, 5)->default(0);
            $table->decimal('change', 18, 5)->default(0);
            $table->tinyInteger('status')->default(0); //1 facturada
            $table->decimal('cxp_pending_amount', 18, 5)->default(0);
            $table->datetime('fecha_factura')->nullable();
            $table->string('factura_proveedor')->nullable();
            $table->decimal('ajuste', 18, 5)->default(0);
            $table->timestamps();
        });

        Schema::create('purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_id')->index();
            $table->foreign('purchase_id')->references('id')->on('purchases')->onDelete('cascade');
            $table->string('Codigo');
            $table->char('CodigoTipo', 2)->default('01');
            $table->string('Detalle');
            $table->decimal('Cantidad', 16, 3)->default(0);
            $table->string('UnidadMedida');
            $table->decimal('PrecioUnitario', 18, 5)->default(0);
            $table->decimal('MontoTotal', 18, 5)->default(0);
            $table->decimal('PorcentajeDescuento', 4, 2)->default(0);
            $table->decimal('PorcentajeDescuento2', 4, 2)->default(0);
            $table->decimal('MontoDescuento', 18, 5)->default(0);
            $table->string('NaturalezaDescuento')->nullable();
            $table->decimal('SubTotal', 18, 5)->default(0);
            $table->decimal('totalTaxes', 18, 5)->default(0);
            $table->decimal('MontoTotalLinea', 18, 5)->default(0);
            $table->tinyInteger('updateStock')->default(1); //1 actualizar inventario
            $table->tinyInteger('exo')->default(0); //1 actualizar inventario
            $table->char('type', 2)->default('P'); //Producto o Servicio
            $table->decimal('utilidad', 6, 2)->default(0);
            $table->tinyInteger('ingresado_inventario')->default(0);
            $table->decimal('unidades', 16, 3)->default(0);
            $table->decimal('precioUnidad', 18, 5)->default(0);
            $table->timestamps();
        });

        Schema::create('purchase_line_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('purchase_line_id')->index();
            $table->char('code', 2)->default('01');
            $table->decimal('tarifa', 4, 2);
            $table->decimal('amount', 18, 5);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('purchase_line_taxes');
        Schema::dropIfExists('purchase_lines');
        Schema::dropIfExists('purchases');
    }
}
