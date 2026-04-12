
 <invoice-form
    :current-invoice="{{ json_encode(isset($invoice) ? $invoice : '')  }}"
    :tipo-documentos="{{ json_encode($tipoDocumentos) }}"
    :tipo-documentos-notas="{{ json_encode($tipoDocumentosNotas) }}"
    :tipo-documentos-exo="{{ json_encode($tipoDocumentosExo) }}"
    :tipo-identificaciones="{{ json_encode($tipoIdentificaciones) }}"
    :codigo-referencias="{{ json_encode($codigoReferencias) }}"
    :medio-pagos="{{ json_encode($medioPagos) }}"
    :condicion-ventas="{{ json_encode($condicionVentas) }}"
    current-tipo-documento="{{ $tipoDocumento }}"
    is-creating-nota="{{ isset($creatingNota) ? '1' : ''  }}"
    :proforma="{{ json_encode(isset($proforma) ? $proforma : '') }}"
    :users="{{ json_encode($users) }}"
    :current-user="{{ auth()->user() }}"
    :setting="{{ $setting }}"
    :caja = "{{isset($caja) ? $caja : ''}}"
    :currency = "{{ $currency }}"
    >
</invoice-form>