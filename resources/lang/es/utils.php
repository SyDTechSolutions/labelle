<?php 

return [
    'status_user' => [
        '0' => 'Inactivo',
        '1' => 'Activo'
    ],
    
    'status_user_color' => [
        '0' => 'danger',
        '1' => 'success',
       
    ],
    'status_hacienda_color' => [
        'aceptado' => 'success',
        'recibido' => 'warning',
        'procesando' => 'warning',
        'rechazado' => 'danger',
        'error' => 'danger'
    ],
    'tipo_documento_color' => [
        '01' => 'success',
        '02' => 'warning',
        '03' => 'danger',
        '04' => 'info',
        '05' => 'info',
        '06' => 'info',
        '07' => 'info',
        '08' => 'info',
        '10' => 'info'
    ],
    'tipo_documento' => [
        '01' => 'Factura electrónica',
        '02' => 'Nota débito electrónica',
        '03' => 'Nota crédito electrónica',
        '04' => 'Tiquete electrónico',
        '05' => 'Nota de despacho',
        '06' => 'Contrato',
        '07' => 'Procedimiento',
        '08' => 'Comprobante emitido en contingencia',
        '10' => 'Recibo de Pago',
        '99' => 'Otro'
    ],

    'medio_pago' => [
        '01' => 'Efectivo',
        '02' => 'Tarjeta',
        '03' => 'Cheque',
        '04' => 'Transferencia – depósito bancario',
        '06' => 'SINPE móvil'

    ],
    'condicion_venta' => [
        '01' => 'Contado',
        '02' => 'Crédito',
        '11' => 'Ventas a crédito'

    ],
    'codigo_referencia' => [
        '01' => 'Anula Documento de Referencia',
        '02' => 'Corrige texto documento de referencia',
        '03' => 'Corrige monto',
        '04' => 'Referencia a otro documento',
        '05' => 'Sustituye comprobante provisional por contingencia',
        '99' => 'Otro',

    ],

    'tipo_mensaje_receptor' => [
        '1' => 'Aceptado',
        '2' => 'Aceptado Parcialmente',
        '3' => 'Rechazado',
        
    ],
   
];
