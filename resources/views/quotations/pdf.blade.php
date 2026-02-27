<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quotation {{ $quotation->quotation_number }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; font-size: 12px; color: #333; }
        .container { padding: 40px; }
        .header { margin-bottom: 30px; }
        .header h1 { font-size: 28px; margin-bottom: 10px; color: #7c3aed; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th { background: #f0f0f0; padding: 10px; text-align: left; border-bottom: 2px solid #333; }
        td { padding: 8px; border-bottom: 1px solid #ddd; }
        .right { text-align: right; }
        .totals { margin-left: auto; width: 300px; margin-top: 20px; }
        .totals div { padding: 5px 0; display: flex; justify-content: space-between; }
        .total-row { border-top: 2px solid #333; padding-top: 10px; font-weight: bold; font-size: 14px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>QUOTATION</h1>
            <p>{{ $quotation->quotation_number }}</p>
        </div>
        
        <div style="margin-bottom: 30px;">
            <strong>To:</strong><br>
            {{ $quotation->customer->name }}<br>
            @if($quotation->customer->company_name){{ $quotation->customer->company_name }}<br>@endif
            @if($quotation->customer->address){!! nl2br(e($quotation->customer->address)) !!}<br>@endif
        </div>
        
        <div style="margin-bottom: 20px;">
            <strong>Date:</strong> {{ $quotation->created_at->format('d M Y') }}<br>
            <strong>Valid Until:</strong> {{ $quotation->valid_until->format('d M Y') }}<br>
            <strong>Status:</strong> {{ ucfirst($quotation->status) }}
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th class="right">Qty</th>
                    <th class="right">Unit Price</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">$ {{ number_format($item->unit_price, 2) }}</td>
                    <td class="right">$ {{ number_format($item->amount, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="totals">
            <div><span>Subtotal:</span><span>$ {{ number_format($quotation->subtotal, 2) }}</span></div>
            <div><span>GST (9%):</span><span>$ {{ number_format($quotation->gst_amount, 2) }}</span></div>
            <div class="total-row"><span>Total:</span><span>$ {{ number_format($quotation->total, 2) }}</span></div>
        </div>
        
        @if($quotation->notes)
        <div style="margin-top: 30px; padding: 15px; background: #f9f9f9;">
            <strong>Notes:</strong><br>
            {{ $quotation->notes }}
        </div>
        @endif
    </div>
</body>
</html>
