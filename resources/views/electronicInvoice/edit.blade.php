
@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Factura de Compra {{ $invoice->consecutivo }}</h2>
       
        @include('electronicInvoice.partials.form') 
     
    
</div>
@endsection