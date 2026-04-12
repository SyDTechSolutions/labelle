<style>
 * {
  font-size: 12px;
  font-family: 'Times New Roman';
}
    td,
    th,
    tr,
    table {
    border-top: 1px solid black;
    border-collapse: collapse;
    }

    tr.summary, tr.summary td{
        border:none !important;
    }
    
    td.producto,
    th.producto {
    width: 95px;
    max-width: 95px;
    }
    
    td.cantidad,
    th.cantidad {
    width: 40px;
    max-width: 40px;
    word-break: break-all;
    }
    
    td.precio,
    th.precio {
    width: 60px;
    max-width: 60px;
    text-align:right;
    word-break: break-all;
    }
    .break{
        word-break: break-all;
    }
    .centrado {
    text-align: center;
    align-content: center;
    }
    
    .ticket {
    width: 200px;
    max-width: 200px;
    }
    
    img {
    max-width: inherit;
    width: inherit;
    }
    @media print{
        .oculto-impresion, .oculto-impresion *{
            display: none !important;
        }
    }
 </style>


     <div class="ticket">
        <!-- <img src="https://yt3.ggpht.com/-3BKTe8YFlbA/AAAAAAAAAAI/AAAAAAAAAAA/ad0jqQ4IkGE/s900-c-k-no-mo-rj-c0xffffff/photo.jpg" alt="Logotipo"> -->
        <p class="centrado">{{ $setting->configFactura->nombre }}
        <br>{{ $setting->configFactura->identificacion }}
        <br>{{ Illuminate\Support\Str::title($setting->configFactura->otras_senas) }}
        <br>{{ $setting->configFactura->telefono }}
        <br>Cod. Actividad: {{ $setting->configFactura->CodigoActividad }}
        <br>{{ $invoice->TipoDocumentoName }}
        <br>Fecha Impr.{{ date("Y-m-d H:i:s") }}
        <br>Fecha Fac. {{ $invoice->created_at }}
        <br>{{ $invoice->NumeroConsecutivo }}
        <br><span class="break">{{ $invoice->clave_fe }}</span>
        </p>
        <p>
          Vendedor: {{ Optional($invoice->creator)->name }}
        </p>
        <p>
          Cliente: {{ $invoice->cliente }}
          @if($invoice->identificacion_cliente)
            <br>Identificación: {{ $invoice->identificacion_cliente }}
          @endif
        </p>
        <table>
        <thead>
            <tr>
            <th class="cantidad">CANT</th>
            <th class="producto">PRODUCTO</th>
            <th class="precio"></th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->lines as $index => $line)
            <tr>
                <td class="cantidad">{{ money($line->Cantidad,'',2) }}</td>
                <td class="producto">
                    <p>{{ $line->Detalle }}</p>
                    
                </td>
                <td class="precio">{{ money($line->SubTotal,$invoice->CodigoMoneda,2) }}</td>
               
            </tr>
            @endforeach
            <tr class="divider">
                <td class="cantidad"></td>
                <td class="producto"></td>
                <td class="precio"></td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Subtotal</td>
                <td class="precio">{{ money($invoice->TotalVenta,$invoice->CodigoMoneda,2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Descuentos</td>
                <td class="precio">{{ money($invoice->TotalDescuentos,$invoice->CodigoMoneda,2) }}</td>
            </tr>
            @foreach ($taxes as $tax)
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Impuesto ({{ (int)$tax['Tarifa'] }}%) IVA</td>
                <td class="precio">{{ money($tax['TotalMontoImpuesto']) }}</td>
            </tr>
            @endforeach
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Impuestos</td>
                <td class="precio">{{ money($invoice->TotalImpuesto,$invoice->CodigoMoneda,2) }}</td>
            </tr>
            @if($invoice->MedioPago == '02')
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">IVA Devuelto</td>
                <td class="precio">(-) {{ money($invoice->TotalIVADevuelto, $invoice->CodigoMoneda, 2) }}</td>
            </tr>
            @endif
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">TOTAL</td>
                <td class="precio">{{ money($invoice->TotalComprobante,$invoice->CodigoMoneda,2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Pago con</td>
                <td class="precio">{{ money($invoice->pay_with,$invoice->CodigoMoneda,2) }}</td>
            </tr class="summary">
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Cambio</td>
                <td class="precio">{{ money($invoice->change,$invoice->CodigoMoneda,2) }}</td>
            </tr>
        </tbody>
        </table>
        <p class="centrado"><b> Valor en letras:</b> <span class="uppercase">{{ $TotalEnLetras }} {{ $invoice->CodigoMoneda }}</span><br></p>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
        <br>
        {{ $invoice->observations }}
        <br>{{ $setting->notes }}</p>
    </div>
    
<a class="oculto-impresion" href="/invoices/create">Regresar</a>

<script>
    function printSummary() {
            window.print();
        }
        
        window.onload = printSummary;
</script>
