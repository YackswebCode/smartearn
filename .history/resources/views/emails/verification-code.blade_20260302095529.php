<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h1>Hello {{ $user->name }}!</h1>
    <p>Your verification code is: <strong>{{ $code }}</strong></p>
    <p>This code will expire in 10 minutes.</p>
    <p>If you didn't request this, please ignore this email.</p>
</body>
</html>