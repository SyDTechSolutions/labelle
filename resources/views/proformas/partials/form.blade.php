
 <proforma-form
    :current-proforma="{{ json_encode(isset($proforma) ? $proforma : '')  }}"
    :tipo-documentos="{{ json_encode($tipoDocumentos) }}"
    :tipo-documentos-exo="{{ json_encode($tipoDocumentosExo) }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    :condicion-ventas="{{ json_encode($condicionVentas) }}"
    current-tipo-documento="{{ $tipoDocumento }}"
    :users="{{ json_encode($users) }}"
    :current-user="{{ auth()->user() }}"
    >
</proforma-form>