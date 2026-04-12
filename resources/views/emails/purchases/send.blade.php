@component('mail::message')
# {{ $setting->company }}. Nueva Factura de compra 

Adjunto PDF con la factura completa. Resumen de la factura 

<b>Factura #:</b> {{ $purchase->consecutivo }} <br>
<b>Fecha:</b> {{ $purchase->created_at }}<br>
<b>Factura Prov #:</b> {{ $purchase->factura_proveedor }}<br>
<b>Fecha Factura Prov:</b> {{ $purchase->fecha_factura }}<br>
<b>Proveedor:</b> {{ $purchase->cliente }}<br>
<b>Total:</b> {{ money($purchase->TotalComprobante) }}<br>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
