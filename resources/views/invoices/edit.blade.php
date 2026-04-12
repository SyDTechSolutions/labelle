
@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Factura {{ $invoice->consecutivo }}</h2>
       
        @include('invoices.partials.form') 
     
    
</div>
@endsection