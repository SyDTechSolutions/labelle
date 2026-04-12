
 <electronic-invoice
    :current-invoice="{{ json_encode(isset($invoice) ? $invoice : '')  }}"
    :tipo-documentos="{{ json_encode($tipoDocumentos) }}"
    :tipo-documentos-notas="{{ json_encode($tipoDocumentosNotas) }}"
    :tipo-identificaciones="{{ json_encode($tipoIdentificaciones) }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    :condicion-ventas="{{ json_encode($condicionVentas) }}"
    current-tipo-documento="{{ $tipoDocumento }}"
    :users="{{ json_encode($users) }}"
    :current-user="{{ auth()->user() }}"
    :setting="{{ $setting }}"
    >
</electronic-invoice>