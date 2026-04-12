@component('mail::message')
# Respuesta de hacienda con respecto a una factura

La Factura {{ $invoice->NumeroConsecutivo }} tiene estado de {{ $status }} por parte de hacienda. Verfica por que situación ocurrio entrando en facturacion y verficando el estado

@component('mail::button', ['url' => env('APP_URL').'/invoices','color' => 'red'])
Ir a Facturación
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
