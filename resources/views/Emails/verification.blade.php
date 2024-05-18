<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Verify Your Email Address</h1>

<p>Thank you for registering on our platform! To verify your email address and complete your registration, you can use
    the following code:</p>

<p>
    <strong class="center">{{ $user->verification_code }}</strong>
</p>

<p>This code will expire in {{ now()->addMinutes(3)->format('H:i:s') }}.</p>

<p>
    If you did not create an account, please ignore this email.
</p>

<p>Sincerely,</p>
<p>The Website Team</p>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</div>
</body>
</html>


{{--<!DOCTYPE html>
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
    <strong>{{ $user->verification_code }}... (truncated)</strong>
</p>

<p>This code will expire in {{ now()->addMinutes(3)->format('H:i:s') }}.</p>

<p>
    If you did not create an account, please ignore this email.
</p>

<p>Sincerely,</p>
<p>The Website Team</p>
</body>
</html>--}}

