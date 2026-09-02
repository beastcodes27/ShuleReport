<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invitation to ShuleReport</title>
</head>
<body style="margin:0;padding:0;background-color:#f5f7fa;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f5f7fa;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">
                    <tr>
                        <td align="center" style="padding:16px 0 24px;">
                            <h1 style="margin:0;font-size:24px;color:#0d6efd;font-weight:700;">ShuleReport</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#ffffff;border-radius:10px;padding:32px;box-shadow:0 2px 8px rgba(0,0,0,0.05);">
                            <h2 style="margin:0 0 12px;font-size:20px;color:#212529;">You're invited to join ShuleReport</h2>
                            <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#495057;">
                                Hello! You have been invited to create a teacher account on <strong>ShuleReport</strong>,
                                our school management portal. Click the button below to set up your account:
                            </p>
                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
                                <tr>
                                    <td style="background-color:#0d6efd;border-radius:6px;">
                                        <a href="{{ route('register.invite', $invitation->token) }}" style="display:inline-block;padding:12px 28px;color:#ffffff;font-size:15px;font-weight:600;text-decoration:none;">Accept Invitation</a>
                                    </td>
                                </tr>
                            </table>
                            <p style="margin:0 0 16px;font-size:13px;line-height:1.6;color:#6c757d;">
                                If the button above doesn't work, copy and paste this link into your browser:
                            </p>
                            <p style="margin:0 0 16px;word-break:break-all;font-size:13px;color:#0d6efd;">
                                <a href="{{ route('register.invite', $invitation->token) }}" style="color:#0d6efd;">{{ route('register.invite', $invitation->token) }}</a>
                            </p>
                            <p style="margin:0;font-size:12px;color:#adb5bd;">
                                This invitation link can only be used once and will expire once you create your account.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:24px 0 0;font-size:12px;color:#adb5bd;">
                            &copy; {{ date('Y') }} ShuleReport &middot; School Management Portal
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
