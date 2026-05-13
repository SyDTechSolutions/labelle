<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tiquete de Cuenta - {{ $customer->name }}</title>
    <style>
        /* ── Reset ── */
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 11px;
            background: #f0f0f0;
            display: flex;
            justify-content: center;
            padding: 20px 0;
        }

        /* ── Ticket wrapper ── */
        .ticket {
            background: #fff;
            width: 300px;
            padding: 14px 16px;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0,0,0,.15);
        }

        /* ── Header empresa ── */
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
        .header .sub {
            font-size: 10px;
            color: #555;
            margin-top: 2px;
        }

        /* ── Título del tiquete ── */
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

        /* ── Info del cliente ── */
        .section-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            color: #555;
            letter-spacing: .5px;
            margin-bottom: 4px;
        }
        .customer-info {
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .customer-info .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .customer-info .label { color: #555; }
        .customer-info .value { font-weight: bold; text-align: right; max-width: 60%; }

        /* ── Tabla de facturas ── */
        .invoices-section {
            border-bottom: 1px dashed #ccc;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .invoice-row {
            border-bottom: 1px dotted #ddd;
            padding: 4px 0;
        }
        .invoice-row .invoice-header {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
        }
        .invoice-row .invoice-header .fac { color: #222; }
        .invoice-row .invoice-header .debito { color: #c0392b; }
        .invoice-row .meta {
            display: flex;
            justify-content: space-between;
            color: #666;
            font-size: 10px;
            margin-top: 1px;
        }
        .invoice-row .vencido-badge {
            display: inline-block;
            background: #c0392b;
            color: #fff;
            border-radius: 2px;
            padding: 0 4px;
            font-size: 9px;
        }
        .invoice-row .aldia-badge {
            display: inline-block;
            background: #27ae60;
            color: #fff;
            border-radius: 2px;
            padding: 0 4px;
            font-size: 9px;
        }

        /* ── Abonos del bloque de factura ── */
        .payment-row {
            display: flex;
            justify-content: space-between;
            padding: 2px 0 2px 12px;
            color: #27ae60;
            font-size: 10px;
        }
        .payment-row .pago-label { color: #555; }

        /* ── Sub-saldo por factura ── */
        .invoice-saldo {
            display: flex;
            justify-content: space-between;
            padding: 2px 0 4px 12px;
            font-size: 10px;
            font-weight: bold;
        }
        .invoice-saldo .saldo-label { color: #888; }
        .invoice-saldo .saldo-value.pendiente { color: #c0392b; }
        .invoice-saldo .saldo-value.pagado     { color: #27ae60; }

        /* ── Totales generales ── */
        .totals {
            border-bottom: 1px dashed #888;
            padding-bottom: 8px;
            margin-bottom: 8px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 3px;
        }
        .total-row .tl { color: #555; }
        .total-row .tv { font-weight: bold; }
        .total-row.highlight .tv { color: #c0392b; font-size: 13px; }
        .total-row.highlight .tl { font-size: 12px; font-weight: bold; color: #222; }

        /* ── Footer ── */
        .footer {
            text-align: center;
            font-size: 10px;
            color: #777;
            margin-top: 4px;
        }

        /* ── Print ── */
        @media print {
            body { background: #fff; padding: 0; }
            .ticket { box-shadow: none; width: 100%; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
<div class="ticket">

    {{-- ── Encabezado empresa ── --}}
    <div class="header">
        @if($setting && $setting->logo_path)
            <img src="{{ $setting->logo() }}" alt="Logo" style="max-height:40px; margin-bottom:4px;"><br>
        @endif
        <div class="company-name">{{ $setting ? $setting->company : 'Empresa' }}</div>
        @if($setting)
            @if($setting->phone) <div class="sub">Tel: {{ $setting->phone }}</div> @endif
            @if($setting->address) <div class="sub">{{ $setting->address }}</div> @endif
        @endif
    </div>

    {{-- ── Título ── --}}
    <div class="ticket-title">Tiquete de Cuenta</div>

    {{-- ── Info del cliente ── --}}
    <div class="customer-info">
        <div class="section-title">Cliente</div>
        <div class="row">
            <span class="label">Nombre:</span>
            <span class="value">{{ $customer->name }}</span>
        </div>
        @if($customer->identification)
        <div class="row">
            <span class="label">Cédula:</span>
            <span class="value">{{ $customer->identification }}</span>
        </div>
        @endif
        @if($customer->phone)
        <div class="row">
            <span class="label">Teléfono:</span>
            <span class="value">{{ $customer->phone }}</span>
        </div>
        @endif
        <div class="row">
            <span class="label">Fecha:</span>
            <span class="value">{{ now()->format('d/m/Y H:i') }}</span>
        </div>
    </div>

    {{-- ── Detalle por factura ── --}}
    <div class="invoices-section">
        <div class="section-title">Detalle de facturas</div>

        @php
            // Agrupar pagos por invoice_id para el detalle
            $pagosPorFactura = $payments->groupBy('invoice_id');
        @endphp

        @foreach($invoices as $invoice)
            @php
                $pagosDeEstaFactura = $pagosPorFactura->get($invoice->id, collect());
                $totalPagadoFac     = $pagosDeEstaFactura->sum('amount');
                $saldoFac           = (float)$invoice->TotalWithNota - $totalPagadoFac;

                // Días vencidos
                $diasVencidos = 0;
                $fechaVen = $invoice->PlazoCredito;
                if ($fechaVen) {
                    $parsed = \Carbon\Carbon::parse($fechaVen);
                    if ($parsed->isValid() && !\Str::contains($fechaVen, ['días', 'dias'])) {
                        $diasVencidos = $parsed->isPast() ? (int)$parsed->diffInDays(now()) : 0;
                    }
                }
            @endphp

            <div class="invoice-row">
                <div class="invoice-header">
                    <span class="fac">Fac. #{{ $invoice->consecutivo }}</span>
                    <span class="debito">{{ money($invoice->TotalWithNota, '') }}</span>
                </div>
                <div class="meta">
                    <span>{{ \Carbon\Carbon::parse($invoice->created_at)->format('d/m/Y') }}</span>
                    <span>
                        @if($diasVencidos > 0)
                            <span class="vencido-badge">{{ $diasVencidos }} días venc.</span>
                        @else
                            <span class="aldia-badge">Al día</span>
                        @endif
                    </span>
                </div>

                {{-- Abonos de esta factura --}}
                @foreach($pagosDeEstaFactura as $pago)
                <div class="payment-row">
                    <span class="pago-label">↳ Abono {{ \Carbon\Carbon::parse($pago->created_at)->format('d/m/Y') }}</span>
                    <span>{{ money($pago->amount, '') }}</span>
                </div>
                @endforeach

                {{-- Saldo de esta factura --}}
                <div class="invoice-saldo">
                    <span class="saldo-label">Saldo factura:</span>
                    <span class="saldo-value {{ $saldoFac > 0 ? 'pendiente' : 'pagado' }}">
                        {{ money($saldoFac, '') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ── Totales generales ── --}}
    <div class="totals">
        <div class="total-row">
            <span class="tl">Total facturado:</span>
            <span class="tv">{{ money($totalFacturado) }}</span>
        </div>
        <div class="total-row">
            <span class="tl">Total abonado:</span>
            <span class="tv" style="color:#27ae60;">{{ money($totalAbonado) }}</span>
        </div>
        <div class="total-row highlight">
            <span class="tl">SALDO PENDIENTE:</span>
            <span class="tv">{{ money($saldoPendiente) }}</span>
        </div>
    </div>

    {{-- ── Footer ── --}}
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i:s') }}<br>
        Gracias por su preferencia
    </div>

    {{-- Botón imprimir (se oculta al imprimir) --}}
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
