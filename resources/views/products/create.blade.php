@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Crear Producto</h2>
        <form action="{{ url('products') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @include('products.partials.form') 
        </form>
    
</div>
@endsection
@section('scripts')
  <script>
    document.getElementById('inputCabys').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });
  </script>    
@endsection