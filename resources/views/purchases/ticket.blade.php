

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
        <p class="centrado">{{ $setting->company }}
        <br>{{ $setting->ide }}
        <br>{{ $setting->address }}
        <br>{{ $setting->phone }}
        <br>{{ date("Y-m-d H:i:s") }}
        <br>{{ $purchase->consecutivo }}
        <p>
          Creador: {{ Optional($purchase->creator)->name }}
        </p>
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
            @foreach($purchase->lines as $index => $line)
            <tr>
                <td class="cantidad">{{ money($line->Cantidad,'',2) }}</td>
                <td class="producto">
                    <p>{{ $line->Detalle }}</p>
                    
                </td>
                <td class="precio">{{ money($line->SubTotal,'¢',2) }}</td>
               
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
                <td class="precio">{{ money($purchase->TotalVenta,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Descuentos</td>
                <td class="precio">{{ money($purchase->TotalDescuentos,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Impuestos</td>
                <td class="precio">{{ money($purchase->TotalImpuesto,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">TOTAL</td>
                <td class="precio">{{ money($purchase->TotalComprobante + $purchase->ajuste,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">AJUSTE</td>
                <td class="precio">{{ money($purchase->ajuste,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">TOTAL CON AJUSTE</td>
                <td class="precio">{{ money($purchase->TotalComprobante,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Pago con</td>
                <td class="precio">{{ money($purchase->pay_with,'¢',2) }}</td>
            </tr>
            <tr class="summary">
                <td class="cantidad"></td>
                <td class="producto">Cambio</td>
                <td class="precio">{{ money($purchase->change,'¢',2) }}</td>
            </tr>
        </tbody>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
        <br>
        {{ $purchase->observations }}
        <br>{{ $setting->notes }}</p>
    </div>
    
<a class="oculto-impresion" href="/purchases/create">Regresar</a>


<script>
    function printSummary() {
            window.print();
        }
        
        window.onload = printSummary;
</script>
