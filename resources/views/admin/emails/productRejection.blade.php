<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Rejection Notification</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <h2 style="color: #c0392b;">Product Rejection Notification</h2>

    <p>Dear {{ $data['vendor_name'] }},</p>

    <p>
        We regret to inform you that your product
        <strong>"{{ $data['product_name'] }}"</strong> has been rejected.
    </p>

    <p>
        <strong>Reason for rejection:</strong><br>
        {{ $data['admin_feedback'] }}
    </p>

    <p>
        Please review the reason and make the necessary adjustments before resubmitting your product for approval.
    </p>

    <p>Thank you for your understanding.</p>

    <p>Best regards,<br>
        <em>The Review Team</em>
    </p>
</body>

</html>
