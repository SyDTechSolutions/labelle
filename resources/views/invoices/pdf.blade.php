
<div class="container">
    <section class="card">
       <div id="invoice-template" class="card-body">
        <!-- Invoice Company Details -->
        <table style="width:100%;">
            <tr>
                <td>
                    <div class="col-md-6 col-sm-12 text-center text-md-left" style="text-align: left !important;">
                       <div class="media" style="">
                            <img src="{{ $setting->logo() }}" alt="company logo" class="" height="80" style="display:inline-block;">
                            <div class="media-body" style="display:inline-block;">
                            <ul class="px-0 list-unstyled" style="
                                    list-style: none;
                                    padding-left: 0 !important;
                                    padding-right: 0 !important;
                                    margin-left: 0.5rem !important;
                                ">
                                @if($setting->configFactura)
                                <li class="text-bold-800">{{ $setting->configFactura->nombre }}</li>
                                <li class="text-bold-800">{{ $setting->configFactura->nombre_comercial }}</li>
                                <li>{{ $setting->configFactura->identificacion }}</li>
                                <li><small>{{ Illuminate\Support\Str::title($setting->configFactura->otras_senas) }}</small></li>
                                <li>{{ $setting->configFactura->telefono }}</li>
                                @endif
                            </ul>
                            </div>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="col-md-6 col-sm-12 text-center text-md-right" style="text-align: right !important;">
                    <h2>{{ $TipoDocumentoName }}</h2>
                    @if($setting->configFactura)
                    <p class="mb-1"><b>Código Actividad:</b> {{ $setting->configFactura->CodigoActividad }}</p>
                    @endif
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
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
                            @if($identificacion_cliente)
                            <li>Identificación: {{ $identificacion_cliente }}</li>
                            @endif
                            @if(isset($customer))
                            <li>{{ $customer['address'] }}</li>
                            <li>{{ $customer['phone'] }}</li>
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
                      <li class="text-bold-800"><span class="text-muted">Vendedor:</span> {{ isset($creator) ? $creator['name'] : '' }}</li>
                            <li class="text-bold-800"><span class="text-muted">Fecha Factura:</span> {{ $created_at }}</li>
                            <li><span class="text-muted">Condición Venta :</span> {{ $CondicionVentaName }}</li>
                
                            <li><span class="text-muted">Medio Pago :</span> {{ $MedioPagoName }}</li>
                          
                        </ul>
                   
                    </div>

                </td>
            </tr>
        </table>
        <!--/ Invoice Customer Details -->
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

                    <th class="text-right">Cant.</th>

                    <th class="text-right">Subtotal</th>

                    <th class="text-right">Desc.</th>

                    <th class="text-right">Total</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($lines as $index => $line)

                    <tr>

                        @if($CodigoMoneda == "USD")

                            <th scope="row">{{ $index + 1 }}</th>

                            <td>

                            {{ $line['Detalle'] }}

                                

                            </td>

                            <td class="text-right">{{ money($line['PrecioUnitario'],'$') }}</td>

                            <td class="text-right">{{ $line['Cantidad'] }}</td>

                            <td class="text-right">{{ money($line['MontoTotal'],'$') }}</td>

                            <td class="text-right">{{ $line['PorcentajeDescuento'] }}%</td>

                            <td class="text-right">{{ money($line['SubTotal'],'$') }}</td>

                        @else

                            <th scope="row">{{ $index + 1 }}</th>

                            <td>

                            {{ $line['Detalle'] }}

                                

                            </td>

                            <td class="text-right">{{ money($line['PrecioUnitario']) }}</td>

                            <td class="text-right">{{ $line['Cantidad'] }}</td>

                            <td class="text-right">{{ money($line['MontoTotal']) }}</td>

                            <td class="text-right">{{ $line['PorcentajeDescuento'] }}%</td>

                            <td class="text-right">{{ money($line['SubTotal']) }}</td>

                        @endif

                    </tr>

                    @endforeach

                    <tr>

                        <td colspan="7">

                            <hr>

                        </td>

                    </tr>

                    <tr>

                        <td colspan="5">

                           

                        </td>

                        <td>

                            <div class="col-md-5 col-sm-12">

                                <p class="lead">Totales</p>

                                <div class="table-responsive">

                                <table class="table" style="width:100%;">

                                    <tbody>

                                    @if($CodigoMoneda=="USD")

                                        <tr>

                                            <td>Sub Total</td>

                                            <td class="text-right" style="text-align:right;">{{ money($TotalVenta,"$") }}</td>

                                        </tr>

                                        <tr>

                                            <td>Descuentos</td>

                                            <td class="pink text-right text-danger" style="text-align:right;    color: #dc3545 !important;">(-) {{ money($TotalDescuentos,"$") }}</td>

                                        </tr>

                                        <tr>

                                            <td>Impuestos (IVA)</td>

                                            <td class="text-right" style="text-align:right;">{{ money($TotalImpuesto,'$') }}</td>

                                        </tr>

                                        @if($MedioPago == '02')

                                        <tr>

                                            <td>IVA Devuelto:</td>

                                            <td class="pink text-right text-danger" style="text-align:right;color: #dc3545 !important;">(-) {{ money($TotalIVADevuelto,"$") }} </td>

                                        </tr>

                                        @endif

                                        <tr>

                                            <td class="text-bold-800">Total</td>

                                            <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($TotalComprobante,"$") }}</td>

                                        </tr>

                                    @else

                                        <tr>

                                            <td>Sub Total</td>

                                            <td class="text-right" style="text-align:right;">{{ money($TotalVenta) }}</td>

                                        </tr>

                                        <tr>

                                            <td>Descuentos</td>

                                            <td class="pink text-right text-danger" style="text-align:right;    color: #dc3545 !important;">(-) {{ money($TotalDescuentos) }}</td>

                                        </tr>

                                        <tr>

                                            <td>Impuestos (IVA)</td>

                                            <td class="text-right" style="text-align:right;">{{ money($TotalImpuesto) }}</td>

                                        </tr>

                                        @if($MedioPago == '02')

                                        <tr>

                                            <td>IVA Devuelto:</td>

                                            <td class="pink text-right text-danger" style="text-align:right;color: #dc3545 !important;">(-) {{ money($TotalIVADevuelto) }} </td>

                                        </tr>

                                        @endif

                                        <tr>

                                            <td class="text-bold-800">Total</td>

                                            <td class="text-bold-800 text-right" style="text-align:right;"> {{ money($TotalComprobante) }}</td>

                                        </tr>



                                    @endif

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
            <div class="">
                @php( $formatLetras = new \NumberFormatter("es", NumberFormatter::SPELLOUT) )
                @php( $TotalEnLetras = $formatLetras->format($TotalComprobante) )
                <b> Valor en letras:</b> <span class="uppercase" style="text-transform:uppercase;">{{ $TotalEnLetras }} {{ $CodigoMoneda }}</span><br>
                 @if($NumeroConsecutivo)
                 <b>Conse:</b> {{ $NumeroConsecutivo }} <br>
                @endif
                @if($clave_fe)
                <b>Clave:</b> {{ $clave_fe }} <br>
                @endif
            </div>
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <b>Observaciones:</b> {{ $observations }}
                </div>
            
            </div>
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    @include('invoices.partials.notaHacienda')
                </div>
            
            </div>
        </div>
        
    </div>
</section>
</div>
