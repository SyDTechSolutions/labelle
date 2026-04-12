@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/img/facturacion.jpg" data-holder-rendered="true">
                <div class="card-body">
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/invoices" role="button" class="btn btn-primary">Facturación</a>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>
        @if(config('app.type') === 'full')
        <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/img/cxc.jpg" data-holder-rendered="true">
                <div class="card-body">
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/cxc" role="button" class="btn btn-secondary">Cuentas x Cobrar</a>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>
        @endif
        @if(auth()->user()->hasRole('admin'))
         <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/img/inventario.jpg" data-holder-rendered="true">
                <div class="card-body">
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/products" role="button" class="btn btn-info">Inventario</a>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>
         <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/img/clientes.jpg" data-holder-rendered="true">
                <div class="card-body">
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/customers" role="button" class="btn btn-warning">Clientes</a>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>
        @if(config('app.type') === 'full')
         <div class="col-md-4">
              <div class="card mb-4 box-shadow">
                <img class="card-img-top" alt="Thumbnail [100%x225]" style="height: 225px; width: 100%; display: block;" src="/img/proveedores.jpg" data-holder-rendered="true">
                <div class="card-body">
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                      <a href="/providers" role="button" class="btn btn-danger">Proveedores</a>
                      
                    </div>
                    
                  </div>
                </div>
              </div>
        </div>
        @endif
        @endif
       
    </div>
</div>
@endsection
