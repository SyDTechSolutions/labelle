
@extends('layouts.app')
@section('content')
<div class="container">

    <section class="card">
        <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <div id="invoice-company-details" class="row">
            <div class="col-md-6 col-sm-12 text-center text-md-left">
            <div class="media">
                <img src="{{ $setting->logo() }}" alt="company logo" class="" height="80">
                <div class="media-body">
                <ul class="ml-2 px-0 list-unstyled">
                    <li class="text-bold-800">{{ $setting->company }}</li>
                    <li>{{ $setting->ide }}</li>
                    <li>{{ $setting->address }}</li>
                    <li>{{ $setting->phone }}</li>
                    
                </ul>
                </div>
            </div>
            </div>
            <div class="col-md-6 col-sm-12 text-center text-md-right">
            <h2>Cuenta del cliente</h2>
                <ul class="px-0 list-unstyled">
                    <li class="text-bold-800">{{ $customer->name }}</li>
                    <li>{{ $customer->email }}</li>
                    <li>{{ $customer->address }}</li>
                    <li>{{ $customer->phone }}</li>
                
                </ul>
            </div>
        </div>
        <!--/ Invoice Company Details -->
        <!-- Invoice Customer Details -->
        <div id="invoice-customer-details" class="row pt-2">
          
        </div>
        <!--/ Invoice Customer Details -->
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">
            <div class="row">
            <h3>Movimientos de la cuenta</h3>
            <div class="table-responsive col-sm-12">
                <table class="table">
                <thead>
                    <tr>
                        <th>#Fac</th>
                        <th>F.Emisión</th>
                        <th>F.Vencimiento</th>
                        <th>Débito</th>
                        <th>F.Abono</th>
                        <th>Crédito</th>
                        <th>Saldo</th>
                        <th>D.Vencidos</th>   
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $item)
                    <tr>
                    <!--Muestra las facturas que no estan canceladas-->
                        @if($item['saldo']!=0)
                            <th scope="row">{{$item['factura']}}</th>
                            <td class="text-left">{{$item['date']}}</td>
                            <td class="text-left">{{$item['dateVen']}}</td>
                            <td class="text-left">{{money($item['debito'],'')}}</td>
                            <td></td>
                            <td class="text-left">{{money($item['credito'],'')}}</td>
                            <td class="text-left">{{money($item['saldo'],'')}}</td>
                            <td class="text-left">{{$item['dVencidos']}}</td>
                        @endif
                    </tr>

                    @foreach($item['abonos'] as $abono)
                        @if($item['saldo']!=0)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-left">{{$abono['fAbono']}}</td>
                            <td class="text-left">{{money($abono['abono'],'')}}</td>
                            <td></td>
                            <td></td>
                        </tr>
                        @endif
                    @endforeach 

                    @endforeach
                
                </tbody>
                </table>
            </div>
            </div>
            <div class="row">
            <div class="col-md-7 col-sm-12 text-center text-md-left">
                
            </div>
            <div class="col-md-5 col-sm-12">
                {{-- <p class="lead">Totales</p> --}}
                <div class="table-responsive">
                <table class="table" style="font-size:15px;">
                    <tbody>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th class="text-left">Saldo Total: {{ money($customer->TotalCxc) }}</th>
                        <th class="text-right"></th>
                    
                    </tr>
                  
                    </tbody>
                </table>
                </div>
            
            </div>
            </div>
        </div>
        <!-- Invoice Footer -->
        <div id="invoice-footer">
            <div class="row">
            
            <div class="col-md-5 col-sm-12 text-center">
                <button type="button" class="btn btn-light my-1" onclick="printSummary();"><i class="fa fa-paper-plane-o" ></i> Imprimir</button>
              
            </div>
            </div>
        </div>
        <!--/ Invoice Footer -->
    </div>
</section>
</div>
@endsection
@section('scripts')
<script>
    function printSummary() {
            window.print();
        }
        
        window.onload = printSummary;
</script>
@endsection
