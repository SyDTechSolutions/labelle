
@extends('layouts.app')

@section('content')
<div class="container">
         <h2>Proforma #{{ $proforma->consecutivo }}</h2>
    
          @include('proformas.partials.form') 
     
    
</div>
@endsection