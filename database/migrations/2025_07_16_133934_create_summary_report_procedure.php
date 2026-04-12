<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateSummaryReportProcedure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS summary_report;');
        DB::unprepared("CREATE PROCEDURE summary_report (IN p_startdate DATE, IN p_enddate DATE) BEGIN SELECT ROUND(COALESCE(resumen.total_general_ventas, 0),2) AS total_general_ventas, ROUND(COALESCE(resumen.total_efectivo, 0),2) AS total_efectivo, ROUND(COALESCE(resumen.total_tarjeta, 0),2) AS total_tarjeta, ROUND(COALESCE(resumen.total_credito, 0),2) AS total_credito, ROUND(COALESCE(resumen.total_gravado, 0),2) AS total_gravado, ROUND(COALESCE(resumen.total_exento, 0),2) AS total_exento, ROUND(COALESCE(resumen.total_impuestos, 0),2) AS total_impuestos, ROUND(COALESCE(resumen.total_nota_credito, 0),2) AS total_nota_credito, ROUND(COALESCE(resumen.total_nota_debito, 0),2) AS total_nota_debito, ROUND(COALESCE(utilidades.costo_inventario, 0),2) AS costo_inventario, ROUND(COALESCE(utilidades.ganancias, 0),2) AS ganancias FROM (SELECT SUM(TotalComprobante) as total_general_ventas, SUM(IF(MedioPago = '01' AND CondicionVenta = '01', TotalComprobante, 0)) as total_efectivo, SUM(IF(MedioPago = '02' AND CondicionVenta = '01', TotalComprobante, 0)) as total_tarjeta, SUM(IF(CondicionVenta = '02', TotalComprobante, 0)) as total_credito, SUM(TotalGravado) as total_gravado, SUM(TotalExento) as total_exento, SUM(TotalImpuesto) as total_impuestos, SUM(IF(TipoDocumento = '03', TotalComprobante, 0)) as total_nota_credito, SUM(IF(TipoDocumento = '02', TotalComprobante, 0)) as total_nota_debito FROM invoices WHERE created_at between p_startdate and p_enddate ) AS resumen LEFT JOIN (SELECT SUM(p.purchase_price) as costo_inventario, ROUND(SUM(p.price-p.purchase_price),2) as ganancias FROM invoice_lines as il INNER JOIN products as p on il.Codigo = p.code WHERE il.created_at between p_startdate and p_enddate) AS utilidades ON TRUE; END;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS summary_report');
    }
}
