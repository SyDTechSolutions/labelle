@component('mail::message')
# {{ $setting->company }}. Nueva Proforma de compra 

Adjunto PDF con la proforma completa. Resumen de la proforma 

<b>Proforma #:</b> {{ $proformapurchase->consecutivo }} <br>
<b>Fecha:</b> {{ $proformapurchase->created_at }}<br>
<b>Factura Prov #:</b> {{ $proformapurchase->factura_proveedor }}<br>
<b>Fecha Factura Prov:</b> {{ $proformapurchase->fecha_factura }}<br>
<b>Proveedor:</b> {{ $proformapurchase->cliente }}<br>
<b>Total:</b> {{ money($proformapurchase->TotalComprobante) }}<br>

Gracias,<br>
{{ config('app.name') }}
@endcomponent
