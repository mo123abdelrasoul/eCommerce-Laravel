<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>New Order Received</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f7fa; padding:30px;">

    <div
        style="max-width:600px;margin:auto;background:#ffffff;border-radius:8px;overflow:hidden;border:1px solid #e6e6e6;">

        <div style="background:#0066cc; padding:18px; text-align:center; color:white; font-size:20px; font-weight:bold;">
            New Order Received
        </div>

        <div style="padding:25px; color:#333;">
            <p>Hello <strong>{{ $vendor->name }}</strong>,</p>

            <p>A new order has been placed that includes items from your store.</p>

            <p>
                <strong>Order Number:</strong> #{{ $order->order_number }}<br>
                <strong>Order Date:</strong> {{ $order->created_at->format('Y-m-d H:i') }}
            </p>

            <h3 style="margin-top:25px;">Items:</h3>

            <table width="100%" cellpadding="8" cellspacing="0"
                style="border-collapse: collapse; border:1px solid #ddd;text-align:center;">
                <thead>
                    <tr style="background:#fafafa;">
                        <th style="border-bottom:1px solid #ddd;">Product</th>
                        <th style="border-bottom:1px solid #ddd;">Qty</th>
                        <th style="border-bottom:1px solid #ddd;">Price</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orderItems as $item)
                        <tr>
                            <td style="border-bottom:1px solid #eee;">{{ $item->product_name }}</td>
                            <td style="border-bottom:1px solid #eee;">{{ $item->quantity }}</td>
                            <td style="border-bottom:1px solid #eee;">
                                {{ number_format($item->total_price, 2) }} EGP</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align:center; margin-top:30px;">
                <a href="{{ route('vendor.orders.show', ['lang' => app()->getLocale(), 'order' => $order->id]) }}"
                    style="display:inline-block;background:#0066cc;color:white;padding:12px 20px;border-radius:6px;text-decoration:none;font-weight:bold;">
                    View Order Details
                </a>
            </div>

            <p style="margin-top:30px; font-size:14px; color:#666;text-align:center;">
                Thank you for being part of {{ config('app.name') }}!
            </p>
        </div>
    </div>

</body>

</html>
