<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email - Sri Lanka Digital ID System</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px 0; }
        .btn { display: inline-block; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; text-decoration: none; padding: 15px 30px; border-radius: 5px; font-weight: bold; margin: 20px 0; }
        .btn:hover { background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%); }
        .footer { background-color: #f8f9fa; padding: 20px; text-align: center; border-radius: 0 0 10px 10px; margin: 20px -20px -20px -20px; font-size: 12px; color: #666; }
        .warning { background-color: #fff3cd; border: 1px solid #ffeaa7; color: #856404; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .logo { font-size: 16px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">🇱🇰 Sri Lanka Digital ID System</div>
            <h1>Verify Your Email Address</h1>
        </div>

        <div class="content">
            <h2>Welcome to Sri Lanka Digital ID System!</h2>

            <p>Thank you for registering with the Sri Lanka Digital ID System. To complete your registration and secure your account, please verify your email address by clicking the button below:</p>

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $verificationUrl }}" class="btn">Verify Email Address</a>
            </div>

            <p>If the button above doesn't work, copy and paste the following link into your browser:</p>
            <p style="word-break: break-all; background-color: #f8f9fa; padding: 10px; border-radius: 5px; font-family: monospace;">
                {{ $verificationUrl }}
            </p>

            <div class="warning">
                <strong>⚠️ Important:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>This verification link will expire in <strong>24 hours</strong></li>
                    <li>If you didn't create an account, please ignore this email</li>
                    <li>Do not share this link with anyone</li>
                </ul>
            </div>

            <h3>What's Next?</h3>
            <p>Once your email is verified, you'll be able to:</p>
            <ul>
                <li>✅ Submit digital ID applications</li>
                <li>✅ Track your application status</li>
                <li>✅ Download your digital ID card</li>
                <li>✅ Receive important notifications</li>
            </ul>

            <p>If you have any questions or need assistance, please contact our support team at <strong>support@digitalid.gov.lk</strong> or call <strong>+94-11-1234567</strong>.</p>
        </div>

        <div class="footer">
            <p><strong>Sri Lanka Digital ID System</strong><br>
            Ministry of Digital Technology and Enterprise Development<br>
            Government of Sri Lanka</p>

            <p style="margin-top: 15px;">
                This is an automated message. Please do not reply to this email.<br>
                © {{ date('Y') }} Government of Sri Lanka. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
