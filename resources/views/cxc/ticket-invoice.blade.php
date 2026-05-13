<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiquete Abonos - Fac. #{{ $invoice->consecutivo }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        .ticket {
            background: #fff;
            width: 300px;
            padding: 14px 16px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        /* Header empresa */
        .header {
            text-align: center;
            border-bottom: 1px dashed #888;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .header .company-name {
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header .sub { font-size: 10px; color: #555; margin-top: 2px; }

        /* Título */
        .ticket-title {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            background: #222;
            color: #fff;
            padding: 4px 0;
            margin-bottom: 8px;
            border-radius: 2px;
        }

        /* Sección genérica */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }

        /* Info factura */
        .invoice-info {
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .info-row .label { color: #555; }
        .info-row .value { font-weight: bold; text-align: right; max-width: 60%; }

        /* Abonos */
        .payments-section {
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            border-bottom: 1px dotted #eee;
        }
        .payment-row:last-child { border-bottom: none; }
        .payment-row .p-info { color: #555; }
        .payment-row .p-info .p-modo { font-size: 9px; color: #999; }
        .payment-row .p-amount { font-weight: bold; color: #27ae60; }
        .no-payments { color: #999; font-style: italic; text-align: center; padding: 6px 0; }

        /* Totales */
        .totals { border-bottom: 1px dashed #888; padding-bottom: 8px; margin-bottom: 8px; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 3px; }
        .total-row .tl { color: #555; }
        .total-row .tv { font-weight: bold; }
        .total-row.highlight .tv { color: #c0392b; font-size: 13px; }
        .total-row.highlight .tl { font-size: 12px; font-weight: bold; color: #222; }
        .total-row.paid .tv { color: #27ae60; font-size: 13px; }
        .total-row.paid .tl { font-size: 12px; font-weight: bold; color: #222; }

        /* Footer */
        .footer { text-align: center; font-size: 10px; color: #777; margin-top: 4px; }

        @media print {
            body { background: #fff; padding: 0; }
            .ticket { box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="ticket">

    {{-- Encabezado empresa --}}
    <div class="header">
        @if($setting && $setting->logo_path)
            <img src="{{ $setting->logo() }}" alt="Logo" style="max-height:40px; margin-bottom:4px;"><br>
        @endif
        <div class="company-name">{{ $setting ? $setting->company : 'Empresa' }}</div>
        @if($setting)
            @if($setting->phone)  <div class="sub">Tel: {{ $setting->phone }}</div>  @endif
            @if($setting->address)<div class="sub">{{ $setting->address }}</div>      @endif
        @endif
    </div>

    {{-- Título --}}
    <div class="ticket-title">Tiquete de Abonos</div>

    {{-- Datos de la factura --}}
    <div class="invoice-info">
        <div class="section-title">Factura</div>
        <div class="info-row">
            <span class="label">#Consecutivo:</span>
            <span class="value">{{ $invoice->consecutivo }}</span>
        </div>
        <div class="info-row">
            <span class="label">Fecha emisión:</span>
            <span class="value">{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</span>
        </div>
        @if($invoice->customer)
        <div class="info-row">
            <span class="label">Cliente:</span>
            <span class="value">{{ $invoice->customer->name }}</span>
        </div>
        @endif
        @if($invoice->PlazoCredito)
        <div class="info-row">
            <span class="label">Vencimiento:</span>
            <span class="value">{{ $invoice->PlazoCredito }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="label">Monto factura:</span>
            <span class="value" style="color:#c0392b;">{{ money($invoice->TotalComprobante) }}</span>
        </div>
        <div class="info-row">
            <span class="label">Fecha impresión:</span>
            <span class="value">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    {{-- Abonos --}}
    <div class="payments-section">
        <div class="section-title">Abonos realizados</div>
        @forelse($payments as $payment)
        <div class="payment-row">
            <span class="p-info">
                {{ \Carbon\Carbon::parse($payment->created_at)->format('d/m/Y') }}
                @if($payment->modoPago)
                <br><span class="p-modo">{{ $payment->modoPago }}</span>
                @endif
                @if($payment->comprobante)
                <br><span class="p-modo">Comp: {{ $payment->comprobante }}</span>
                @endif
            </span>
            <span class="p-amount">{{ money($payment->amount, '') }}</span>
        </div>
        @empty
        <div class="no-payments">Sin abonos registrados</div>
        @endforelse
    </div>

    {{-- Totales --}}
    <div class="totals">
        <div class="total-row">
            <span class="tl">Total factura:</span>
            <span class="tv">{{ money($invoice->TotalComprobante) }}</span>
        </div>
        <div class="total-row">
            <span class="tl">Total abonado:</span>
            <span class="tv" style="color:#27ae60;">{{ money($totalAbonado) }}</span>
        </div>
        @if($saldoPendiente <= 0)
        <div class="total-row paid">
            <span class="tl">SALDO PENDIENTE:</span>
            <span class="tv">{{ money(0) }}</span>
        </div>
        @else
        <div class="total-row highlight">
            <span class="tl">SALDO PENDIENTE:</span>
            <span class="tv">{{ money($saldoPendiente) }}</span>
        </div>
        @endif
    </div>

    {{-- Footer --}}
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i:s') }}<br>
        Gracias por su preferencia
    </div>

    <div class="no-print" style="text-align:center; margin-top:12px;">
        <button onclick="window.print()" style="font-family:inherit; font-size:11px; padding:5px 18px; cursor:pointer;">
            Imprimir
        </button>
    </div>

</div>
<script>
    window.onload = function () { window.print(); };
</script>
</body>
</html>
