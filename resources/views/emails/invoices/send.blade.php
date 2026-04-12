@component('mail::message')
# {{ $setting->company }}. Nueva Factura 

Adjunto PDF con la factura completa. Resumen de la factura:

<b>Consecutivo:</b> {{ $invoice->NumeroConsecutivo }} <br>
<b>Clave:</b> {{ $invoice->clave_fe }} <br>
<b>Número interno</b>: {{ $invoice->consecutivo }}<br>
<b>Fecha:</b> {{ $invoice->created_at }}<br>
<b>Cliente:</b> {{ $invoice->cliente }}<br>
<b>Total:</b> {{ money($invoice->TotalComprobante, $invoice->CodigoMoneda) }} {{ $invoice->CodigoMoneda }}<br>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
