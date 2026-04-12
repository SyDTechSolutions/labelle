<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProformaPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      
        Schema::create('proforma_purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('provider_id')->index();
            $table->integer('consecutivo');
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
            $table->decimal('TotalServExonerado', 18, 5)->default(0);
            $table->decimal('TotalMercanciasGravadas', 18, 5)->default(0);
            $table->decimal('TotalMercanciasExentas', 18, 5)->default(0);
            $table->decimal('TotalMercExonerada', 18, 5)->default(0);
            $table->decimal('TotalGravado', 18, 5)->default(0);
            $table->decimal('TotalExento', 18, 5)->default(0);
            $table->decimal('TotalExonerado', 18, 5)->default(0);
            $table->decimal('TotalVenta', 18, 5)->default(0);
            $table->decimal('TotalDescuentos', 18, 5)->default(0);
            $table->decimal('TotalVentaNeta', 18, 5)->default(0);
            $table->decimal('TotalImpuesto', 18, 5)->default(0);
            $table->decimal('TotalComprobante', 18, 5)->default(0);
            $table->decimal('TotalWithNota', 18, 5)->default(0);
            $table->decimal('TotalIVADevuelto', 18, 5)->default(0);
            $table->decimal('pay_with', 18, 5)->default(0);
            $table->decimal('change', 18, 5)->default(0);
            $table->tinyInteger('status')->default(0); //1 facturada
            $table->decimal('cxp_pending_amount', 18, 5)->default(0);
            $table->datetime('fecha_factura')->nullable();
            $table->string('factura_proveedor')->nullable();
            $table->decimal('ajuste', 18, 5)->default(0);
            $table->unsignedInteger('created_by')->default(0)->index();
            $table->timestamp('opening')->nullable(); // from generada de comparativa
            $table->text('observations')->nullable();
            $table->timestamps();
        });

        Schema::create('proforma_purchase_lines', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('proforma_purchase_id')->index();
            $table->foreign('proforma_purchase_id')->references('id')->on('proforma_purchases')->onDelete('cascade');
            $table->string('Codigo');
            $table->char('CodigoTipo', 2)->default('01');
            $table->string('CodigoProductoHacienda')->nullable();
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
            $table->decimal('BaseImponible', 18, 5)->default(0);
            $table->decimal('totalTaxes', 18, 5)->default(0);
            $table->decimal('MontoTotalLinea', 18, 5)->default(0);
            $table->tinyInteger('updateStock')->default(1); //1 actualizar inventario
            $table->tinyInteger('exo')->default(0); //1 actualizar inventario
            $table->char('type', 2)->default('P'); //Producto o Servicio
            $table->decimal('utilidad', 6, 2)->default(0);
            $table->tinyInteger('ingresado_inventario')->default(0);
            $table->decimal('unidades', 16, 3)->default(0);
            $table->decimal('precioUnidad', 18, 5)->default(0);
            $table->tinyInteger('is_servicio_medico')->default(0);
            $table->timestamps();
        });

        Schema::create('proforma_purchase_line_taxes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('proforma_purchase_line_id')->index();
            $table->char('code', 2)->default('01');
            $table->decimal('tarifa', 4, 2);
            $table->decimal('amount', 18, 5);
            $table->char('CodigoTarifa', 2)->nullable();
            $table->char('TipoDocumento', 2)->default('01')->nullable();
            $table->string('NumeroDocumento')->nullable();
            $table->string('NombreInstitucion')->nullable();
            $table->datetime('FechaEmision')->nullable();
            $table->decimal('PorcentajeExoneracion', 5, 2)->nullable();
            $table->decimal('MontoExoneracion', 18, 5)->nullable();
            $table->decimal('ImpuestoOriginal', 18, 5)->nullable();
            $table->decimal('ImpuestoNeto', 18, 5)->nullable();
            $table->string('name')->nullable();
            $table->decimal('TarifaOriginal', 18, 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proforma_purchase_line_taxes');
        Schema::dropIfExists('proforma_purchase_lines');
        Schema::dropIfExists('proforma_purchases');
    }
}
