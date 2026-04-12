
@extends('layouts.app')

@section('content')
<div class="container-fluid">
         <h2>Factura #{{ $purchase->consecutivo }}</h2>
    
          @include('purchases.partials.form') 
     
    
</div>
@endsection