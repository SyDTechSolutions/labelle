<table class="table">
    <thead>
        <tr>
            <th scope="col">Documento</th>
            <th scope="col">Tipo Documento</th>
            <th scope="col">Fecha</th>
            <th scope="col">Fecha Emisión</th>
            <th scope="col">Nombre Receptor</th>
            <th scope="col">Cédula Receptor</th>
            <th scope="col">Moneda</th>
            <th scope="col">Condición Venta</th>
            <th scope="col">Total Impuesto</th>
            <th scope="col">Total Factura</th>
            
        </tr>
    </thead>
    <tbody>
    @foreach($receptors as $receptor)
        <tr>
            <th scope="row">{{ $receptor->NumeroConsecutivo }}</th>
            <td>{{ $receptor->tipoDocumentoName }}</td>
            <td>{{ $receptor->created_at }}</td>
            <td>{{ $receptor->FechaEmisionFactura }}</td>
            <td>{{ $receptor->NumeroCedulaEmisor }}</td>
            <td>{{ $receptor->nombre_emisor }}</td>
            <td>{{ $receptor->CodigoMoneda }}</td>
            <td>{{ $receptor->CondicionVentaName }}</td>
            <td>{{ $receptor->MontoTotalImpuesto }}</td>
            <td>{{ $receptor->TotalFactura }}</td>
        </tr>
    @endforeach
    </tbody>
</table>  