<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
</head>
<body>
<h1>Verify Your Email Address</h1>

    <p>Thank you for registering on our platform! To verify your email address and complete your registration, you can use
    the following code:</p>

    <p>
        <strong>{{ substr($user->verification_code, 0, 6) }}... (truncated)</strong>
    </p>

    <p>This code will expire in {{ now()->addMinutes(3)->format('H:i:s') }}.</p>

    <p>
        If you did not create an account, please ignore this email.
    </p>

<p>Sincerely,</p>
<p>The Website Team</p>
</body>
</html>
