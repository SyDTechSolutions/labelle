
 <proforma-purchase-form
    :current-proforma="{{ json_encode(isset($proformaPurchase) ? $proformaPurchase : '')  }}"
    :tipo-documentos="{{ json_encode($tipoDocumentos) }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    :condicion-ventas="{{ json_encode($condicionVentas) }}"
    current-tipo-documento="{{ $tipoDocumento }}"
    :tipo-identificaciones="{{ json_encode($tipoIdentificaciones) }}"
    :providers="{{ json_encode($providers) }}"
    :medidas="{{ json_encode($measures) }}"
    :taxes="{{ json_encode($taxes) }}"
    
    >
</proforma-purchase-form>