<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmartEarn – Verify Your Email</title>
    <style>
        /* Inline styles are used for email clients, but we keep a style block for any non-inline fallbacks.
           Most email clients ignore <style> except for some, so we'll rely on inline styles primarily. */
    </style>
</head>
<body style="margin:0; padding:0; background-color:#EEF0F8; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <center style="width:100%;table-layout:fixed;">
        <table align="center" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:600px; background-color:#EEF0F8; padding:20px;">
            <tr>
                <td align="center" style="padding:0;">
                    <!-- Main Card -->
                    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#ffffff; border-radius:24px; box-shadow:0 8px 20px rgba(0,0,0,0.05); overflow:hidden;">
                        <!-- Header with brand mark -->
                        <tr>
                            <td align="center" style="padding:40px 30px 20px 30px; background: linear-gradient(145deg, #065754 0%, #0b7a76 100%);">
                                <table cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td align="center" style="background-color:#ffffff; width:64px; height:64px; border-radius:16px; box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                                            <span style="font-size:32px; font-weight:800; color:#065754; line-height:64px;">SE</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="padding-top:12px;">
                                            <span style="font-size:24px; font-weight:600; color:#ffffff;">SmartEarn</span>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Body -->
                        <tr>
                            <td align="center" style="padding:40px 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td align="center" style="font-size:28px; font-weight:700; color:#065754; padding-bottom:8px;">
                                            Verify Your Email
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="font-size:16px; color:#4a5568; padding-bottom:24px;">
                                            Hello <strong style="color:#065754;">{{ $user->name }}</strong>,<br>
                                            use the verification code below to complete your registration.
                                        </td>
                                    </tr>
                                    <!-- Code display box -->
                                    <tr>
                                        <td align="center" style="background-color:#EEF0F8; border-radius:16px; padding:24px; margin:10px 0;">
                                            <span style="font-size:14px; text-transform:uppercase; letter-spacing:2px; color:#065754; font-weight:600;">Verification code</span>
                                            <div style="font-size:48px; font-weight:800; color:#48BB78; line-height:1.2; margin:8px 0 4px;">{{ $code }}</div>
                                            <span style="font-size:14px; color:#718096;">(valid for 10 minutes)</span>
                                        </td>
                                    </tr>
                                    <!-- Expiry note -->
                                    <tr>
                                        <td align="center" style="padding:24px 0 8px; font-size:14px; color:#718096;">
                                            This code will expire in 10 minutes.
                                        </td>
                                    </tr>
                                    <!-- Divider -->
                                    <tr>
                                        <td align="center" style="padding:16px 0 8px;">
                                            <table width="60px" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td style="height:2px; background-color:#EEF0F8;"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <!-- Ignore message -->
                                    <tr>
                                        <td align="center" style="font-size:14px; color:#a0aec0;">
                                            If you didn't request this, please ignore this email.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <!-- Footer -->
                        <tr>
                            <td align="center" style="background-color:#065754; padding:20px 30px;">
                                <span style="font-size:14px; color:#ffffff; opacity:0.8;">© 2025 SmartEarn. All rights reserved.</span>
                            </td>
                        </tr>
                    </table>
                    <!-- Small note for email clients -->
                    <p style="font-size:12px; color:#718096; margin-top:16px;">This is an automated message, please do not reply.</p>
                </td>
            </tr>
        </table>
    </center>
</body>
</html>