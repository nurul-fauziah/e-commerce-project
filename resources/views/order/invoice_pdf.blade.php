<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $productTransaction->invoice_number }}</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
            margin: 0;
            padding: 0;
            background: #ffffff;
        }

        .invoice-wrapper {
            padding: 28px;
        }

        .top-bar {
            background: #0f172a;
            color: #ffffff;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 24px;
        }

        .brand {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .brand-subtitle {
            font-size: 12px;
            color: #cbd5e1;
        }

        .invoice-title {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .invoice-number {
            text-align: right;
            margin-top: 6px;
            color: #cbd5e1;
            font-size: 11px;
        }

        .row {
            width: 100%;
            clear: both;
        }

        .col-left {
            width: 50%;
            float: left;
        }

        .col-right {
            width: 50%;
            float: right;
        }

        .card {
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            background: #ffffff;
        }

        .card-title {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #64748b;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .customer-name {
            font-size: 15px;
            font-weight: bold;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .muted {
            color: #64748b;
            line-height: 1.6;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            background: #dcfce7;
            color: #166534;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 5px 0;
            vertical-align: top;
        }

        .info-label {
            color: #64748b;
            width: 90px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }

        .items-table th {
            background: #f1f5f9;
            color: #0f172a;
            text-align: left;
            padding: 12px 10px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            border-bottom: 1px solid #e5e7eb;
        }

        .items-table td {
            padding: 12px 10px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
        }

        .product-name {
            font-weight: bold;
            color: #111827;
        }

        .right {
            text-align: right;
        }

        .center {
            text-align: center;
        }

        .summary-wrapper {
            width: 100%;
            margin-top: 22px;
        }

        .summary-box {
            width: 310px;
            float: right;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }

        .summary-table td {
            padding: 11px 14px;
            border-bottom: 1px solid #e5e7eb;
        }

        .summary-table tr:last-child td {
            border-bottom: none;
        }

        .summary-label {
            color: #64748b;
        }

        .summary-total {
            background: #0f172a;
            color: #ffffff;
            font-size: 15px;
            font-weight: bold;
        }

        .footer {
            clear: both;
            margin-top: 42px;
            padding-top: 18px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #64748b;
            line-height: 1.6;
        }

        .footer strong {
            color: #0f172a;
        }
    </style>
</head>

<body>
<div class="invoice-wrapper">

    <div class="top-bar">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;">
                    <div class="brand">SmartTech</div>
                    <div class="brand-subtitle">
                        Premium Gadget & Tech Store
                    </div>
                </td>
                <td style="width: 50%;">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">
                        {{ $productTransaction->invoice_number }}
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-left">
            <div class="card" style="margin-right: 10px;">
                <div class="card-title">Bill To</div>

                <div class="customer-name">
                    {{ $productTransaction->name }}
                </div>

                <div class="muted">
                    {{ $productTransaction->phone }}<br>
                    {{ $productTransaction->address }}
                </div>
            </div>
        </div>

        <div class="col-right">
            <div class="card" style="margin-left: 10px;">
                <div class="card-title">Transaction Info</div>

                <table class="info-table">
                    <tr>
                        <td class="info-label">Status</td>
                        <td>
                            <span class="status-badge">
                                {{ strtoupper($productTransaction->status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Date</td>
                        <td>
                            {{ $productTransaction->created_at->format('d M Y') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="info-label">Invoice</td>
                        <td>
                            {{ $productTransaction->invoice_number }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div style="clear: both;"></div>

    <div class="card">
        <div class="card-title">Order Details</div>

        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 45%;">Product</th>
                    <th class="center" style="width: 12%;">Qty</th>
                    <th class="right" style="width: 20%;">Price</th>
                    <th class="right" style="width: 23%;">Subtotal</th>
                </tr>
            </thead>

            <tbody>
                @foreach($productTransaction->transactionDetails as $item)
                    <tr>
                        <td>
                            <div class="product-name">
                                {{ $item->product->name ?? 'Product' }}
                            </div>
                        </td>
                        <td class="center">
                            {{ $item->quantity }}
                        </td>
                        <td class="right">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td class="right">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="summary-wrapper">
        <div class="summary-box">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">Subtotal</td>
                    <td class="right">
                        Rp {{ number_format($productTransaction->sub_total_amount, 0, ',', '.') }}
                    </td>
                </tr>

                <tr>
                    <td class="summary-label">Discount</td>
                    <td class="right">
                        - Rp {{ number_format($productTransaction->discount_amount, 0, ',', '.') }}
                    </td>
                </tr>

                <tr class="summary-total">
                    <td>Total</td>
                    <td class="right">
                        Rp {{ number_format($productTransaction->grand_total_amount, 0, ',', '.') }}
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="footer">
        <strong>Terima kasih telah berbelanja di SmartTech.</strong><br>
        Simpan invoice ini sebagai bukti transaksi resmi kamu.
    </div>

</div>
</body>
</html>
