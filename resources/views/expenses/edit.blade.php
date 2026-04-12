
@extends('layouts.app')

@section('content')
<div class="container">
        <h2>Gasto {{ $expense->id }}</h2>
       
        @include('expenses._form') 
     
    
</div>
@endsection