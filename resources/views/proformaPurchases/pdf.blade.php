

<div class="container">
    <section class="card">
       <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <table style="width:100%;">
            <tr>
                <td>
                    <div class="col-md-6 col-sm-12 text-center text-md-left" style="text-align: left !important;">
                       <div class="media" >
                            <img src="{{ $setting->logo() }}" alt="company logo" class="" height="80" style="display:inline-block;">
                            <div class="media-body" style="display:inline-block;">
                            <ul class="px-0 list-unstyled" style="
                                    list-style: none;
                                    padding-left: 0 !important;
                                    padding-right: 0 !important;
                                    margin-left: 0.5rem !important;
                                ">
                                <li class="text-bold-800">{{ $setting->company }}</li>
                                <li>{{ $setting->ide }}</li>
                                <li>{{ $setting->address }}</li>
                                <li>{{ $setting->phone }}</li>
                                
                            </ul>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-md-6 col-sm-12 text-center text-md-right" style="text-align: right !important;">
                    <h2>Proforma Compra</h2>
                    <p class="pb-3"># {{ $consecutivo }}</p>
                    <ul class="px-0 list-unstyled" style="
                        list-style: none;
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    ">
                        <li>Total</li>
                        <li class="lead text-bold-800">{{ money($TotalComprobante) }}</li>
                    </ul>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                      
                        <span class="text-muted">Facturado A:</span>
                        
                        <div class="col-md-6 col-sm-12 text-center text-md-left" style="text-align: left !important;">
                        <ul class="px-0 list-unstyled" style="
                        list-style: none;
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    ">
                            <li class="text-bold-800">{{ $cliente }}</li>
                            <li>{{ $email }}</li>
                            @if(isset($provider))
                            <li>{{ $provider['address'] }}</li>
                            <li>{{ $provider['phone'] }}</li>
                            @endif
                        </ul>
                    </div>
                </td>
                <td>

                    <div class="col-md-6 col-sm-12 text-center text-md-right" style="text-align: right !important;">
                    <ul class="px-0 list-unstyled" style="
                        list-style: none;
                        padding-left: 0 !important;
                        padding-right: 0 !important;
                    ">
                            <li class="text-bold-800"><span class="text-muted">Creador:</span> {{ isset($creator) ? $creator['name'] : '' }}</li>
                            <li class="text-bold-800"><span class="text-muted">Fecha Factura:</span> {{ $created_at }}</li>
                            <li><span class="text-muted">Condición Venta :</span> {{ $CondicionVentaName }}</li>
                
                            <li><span class="text-muted">Medio Pago :</span> {{ $MedioPagoName }}</li>
                          
                        </ul>
                   
                    </div>

                </td>
            </tr>
        </table>
        <!--/ Invoice provider Details -->
        <!-- Invoice Items Details -->
        <div id="invoice-items-details" class="pt-2">
            <div class="row">
            <hr/>
            <div class="table-responsive col-sm-12">
                <table class="table" style="width:100%;">
                <thead>
                    <tr>
                    <th>#</th>
                    <th>Item &amp; Descripción</th>
                    <th class="text-right">Precio Unitario</th>
                    <th class="text-right">Cantidad</th>
                    <th class="text-right">% Descuento</th>
                    <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($lines as $index => $line)
                    <tr>
                        <th scope="row">{{ $index + 1 }}</th>
                        <td>
                           {{ $line['Detalle'] }}
                            
                        </td>
                        <td class="text-right">{{ money($line['PrecioUnitario']) }}</td>
                        <td class="text-right">{{ $line['Cantidad'] }}</td>
                        <td class="text-right">{{ $line['PorcentajeDescuento'] }}</td>
                        <td class="text-right">{{ money($line['SubTotal']) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="6">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                           
                        </td>
                        <td>
                            <div class="col-md-5 col-sm-12">
                                <p class="lead">Totales</p>
                                <div class="table-responsive">
                                <table class="table" style="width:100%;">
                                    <tbody>
                                    <tr>
                                        <td>Sub Total</td>
                                        <td class="text-right" style="text-align:right;">{{ money($TotalVenta) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Descuentos</td>
                                        <td class="pink text-right text-danger" style="text-align:right;    color: #dc3545 !important;">(-) {{ money($TotalDescuentos) }}</td>
                                    </tr>
                                    <tr>
                                        <td>Impuestos (13%)</td>
                                        <td class="text-right" style="text-align:right;">{{ money($TotalImpuesto) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-800">Total</td>
                                        <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($TotalComprobante + $ajuste) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-800">Ajuste</td>
                                        <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($ajuste) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-800">Total con Ajuste</td>
                                        <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($TotalComprobante) }}</td>
                                    </tr>
                                    <!-- <tr>
                                        <td>Pago con</td>
                                        <td class="pink text-right" style="text-align:right;">{{ money($pay_with) }}</td>
                                    </tr>
                                    <tr class="bg-grey bg-lighten-4">
                                        <td class="text-bold-800">Cambio</td>
                                        <td class="text-bold-800 text-right" style="text-align:right;">{{ money($change) }}</td>
                                    </tr> -->
                                    </tbody>
                                </table>
                                </div>
                            
                            </div>

                        </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
            
        </div>
        <br>
        <br>
        <div id="invoice-footer">
           
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <b>Observaciones:</b> {{ $observations }}
                </div>
            
            </div>
            
        </div>
        
    </div>
</section>
</div>
