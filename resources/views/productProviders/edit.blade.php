
@extends('layouts.app')

@section('content')
<div class="container-fluid">
         <h2>Comparativa #{{ $productprovider->consecutivo }}</h2>
    
          @include('productProviders.partials.form') 
     
    
</div>
@endsection