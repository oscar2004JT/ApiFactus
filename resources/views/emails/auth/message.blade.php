<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; color:#111827;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="width:100%; background-color:#f3f4f6; margin:0; padding:0;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:640px; width:100%;">
                    <tr>
                        <td style="padding:0 8px 18px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="width:56px; vertical-align:middle;">
                                        <table role="presentation" width="48" cellpadding="0" cellspacing="0" style="width:48px; height:48px; border-radius:16px; background-color:#16a34a;">
                                            <tr>
                                                <td align="center" valign="middle" style="font-family:Arial, Helvetica, sans-serif; font-size:24px; font-weight:700; color:#ffffff;">
                                                    A
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="vertical-align:middle; padding-left:12px;">
                                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:20px; font-weight:700; color:#111827;">{{ $appName }}</div>
                                        <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; color:#6b7280;">Sistema de gestion ganadera</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="background-color:#ffffff; border-radius:28px; overflow:hidden; border:1px solid #e5e7eb; box-shadow:0 18px 45px rgba(15, 23, 42, 0.08);">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="height:8px; background-color:#16a34a;"></td>
                                </tr>
                                <tr>
                                    <td style="padding:36px 32px 20px; background:linear-gradient(180deg, #f0fdf4 0%, #ffffff 100%);">
                                        <span style="display:inline-block; padding:8px 14px; border-radius:999px; background-color:#dcfce7; color:#166534; font-family:Arial, Helvetica, sans-serif; font-size:12px; font-weight:700; letter-spacing:0.04em; text-transform:uppercase;">
                                            {{ $eyebrow }}
                                        </span>
                                        <h1 style="margin:18px 0 12px; font-family:Arial, Helvetica, sans-serif; font-size:30px; line-height:1.2; color:#111827;">
                                            {{ $heading }}
                                        </h1>
                                        @if (!empty($recipientName))
                                            <p style="margin:0 0 10px; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.7; color:#374151;">
                                                Hola {{ $recipientName }},
                                            </p>
                                        @endif
                                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:1.8; color:#4b5563;">
                                            {{ $intro }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 32px 28px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f8fafc; border:1px solid #dbeafe; border-radius:22px;">
                                            <tr>
                                                <td style="padding:20px 22px;">
                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:14px; font-weight:700; color:#166534; margin-bottom:8px;">
                                                        {{ $detailTitle }}
                                                    </div>
                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.7; color:#475569;">
                                                        {{ $detailText }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center" style="padding:0 32px 24px;">
                                        <a href="{{ $buttonUrl }}" style="display:inline-block; padding:15px 28px; border-radius:16px; background-color:#16a34a; color:#ffffff; font-family:Arial, Helvetica, sans-serif; font-size:15px; font-weight:700; text-decoration:none;">
                                            {{ $buttonText }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 32px 24px;">
                                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.8; color:#4b5563;">
                                            {{ $secondaryText }}
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 32px 28px;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9fafb; border:1px dashed #cbd5e1; border-radius:18px;">
                                            <tr>
                                                <td style="padding:18px 20px;">
                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; font-weight:700; color:#374151; margin-bottom:8px;">
                                                        Si el boton no funciona, copia y pega este enlace en tu navegador:
                                                    </div>
                                                    <div style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:1.7; word-break:break-all;">
                                                        <a href="{{ $buttonUrl }}" style="color:#15803d; text-decoration:none;">{{ $buttonUrl }}</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding:0 32px 34px;">
                                        <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:1.8; color:#374151;">
                                            {{ $farewell }}<br>{{ $appName }}
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:18px 12px 0; text-align:center;">
                            <p style="margin:0; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:1.7; color:#6b7280;">
                                {{ $footerText }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
