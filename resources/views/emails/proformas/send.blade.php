@component('mail::message')
# {{ $setting->company }}. Nueva Proforma 

Adjunto PDF con la proforma completa. Resumen de la proforma:

<b>Número interno</b>: {{ $proforma->consecutivo }}<br>
<b>Fecha:</b> {{ $proforma->created_at }}<br>
<b>Cliente:</b> {{ $proforma->cliente }}<br>
<b>Total:</b> {{ money($proforma->TotalComprobante,'') }} {{ $proforma->CodigoMoneda }}<br>


Gracias,<br>
{{ config('app.name') }}
@endcomponent
