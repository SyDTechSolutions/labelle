
 <purchase-form
    :current-purchase="{{ json_encode(isset($purchase) ? $purchase : '')  }}"
    :tipo-documentos="{{ json_encode($tipoDocumentos) }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    :condicion-ventas="{{ json_encode($condicionVentas) }}"
    current-tipo-documento="{{ $tipoDocumento }}"
    :tipo-identificaciones="{{ json_encode($tipoIdentificaciones) }}"
    :providers="{{ json_encode($providers) }}"
    :medidas="{{ json_encode($measures) }}"
    :taxes="{{ json_encode($taxes) }}"
    :proforma="{{ json_encode(isset($proforma) ? $proforma : '') }}"
    >
</purchase-form>