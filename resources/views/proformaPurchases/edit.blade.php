
@extends('layouts.app')

@section('content')
<div class="container-fluid">
         <h2>Proforma Compra #{{ $proformaPurchase->consecutivo }}</h2>
    
          @include('proformaPurchases.partials.form') 
     
    
</div>
@endsection