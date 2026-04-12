<table class="table">
    <thead>
        <tr>
            <th scope="col">Fecha</th>
            <th scope="col">Referencia</th>
            <th scope="col">Metodo Pago</th>
            <th scope="col">IVA 1%</th>
            <th scope="col">IVA 2%</th>
            <th scope="col">IVA 4%</th>
            <th scope="col">IVA 13%</th>
            <th scope="col">Total IVA</th>
            <th scope="col">Total</th>
            
            
        </tr>
    </thead>
    <tbody>
        @foreach($gastos as $x=>$i)
        <tr>
            <th scope="row">{{$gastos[$x]['fecha']}}</th>
            <td>{{$gastos[$x]['referencia']}}</td>
            <td>{{$gastos[$x]['metodoPago']}}</td>
            <td>{{$gastos[$x]['Iva1']}}</td>
            <td>{{$gastos[$x]['Iva2']}}</td>
            <td>{{$gastos[$x]['Iva4']}}</td>
            <td>{{$gastos[$x]['Iva13']}}</td>
            <td>{{$gastos[$x]['totalIva']}}</td>
            <td>{{$gastos[$x]['total']}}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7"></td>
            <td>
                <b>Impuestos: {{ money($totalTaxes) }}</b> <br> 
            </td>
            <td>
                <b>Total: {{ money($total) }}</b> <br> 
            </td>
            
        </tr>

    </tbody>
</table>
                        