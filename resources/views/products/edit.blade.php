
@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Editar Producto</h2>
        <form action="{{ url('products/'. $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          @include('products.partials.form') 
        </form>
    
</div>
@endsection
@section('scripts')
<script src="/js/JsBarcode.all.min.js"></script>
<script>

    JsBarcode("#barcode{{ $product->id }}", "{{ $product->code }}",{
        format:"CODE128",
        lineColor: "#000",
        width: 2,
        height: 40,
        displayValue: true
    });

    document.getElementById('inputCabys').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            event.preventDefault();
        }
    });


</script>
@endsection