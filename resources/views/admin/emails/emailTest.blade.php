<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $data['subject'] ?? 'Notification' }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f4f4;border-radius:10px;">
    <table width="100%" cellpadding="0" cellspacing="0"
        style="margin:auto; background:#fff; border-radius:8px; overflow:hidden;">
        <tr>
            <td
                style="background:#c0392b; color:#fff; text-align:center; padding:20px 0; font-size:22px; font-weight:bold;">
                {{ config('app.name') }}
            </td>
        </tr>
        <tr>
            <td style="padding:30px; color:#333; font-family:Arial, sans-serif; line-height:1.6;">
                <h2 style="color:#c0392b; margin-bottom:15px;">{{ $data['title'] ?? 'Hello!' }}</h2>
                <p style="margin-bottom:20px;">{{ $data['message'] }}</p>
                <p>Thank you,<br><strong>{{ config('mail.from.name') }}</strong></p>
            </td>
        </tr>
        <tr>
            <td style="background:#eee; text-align:center; padding:15px; font-size:12px; color:#666;">
                &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </td>
        </tr>
    </table>
</body>

</html>
