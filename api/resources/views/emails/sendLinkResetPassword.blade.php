<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:100,300,400,500,700,900">
    <title>Reset password in Schedulia</title>

</head>
<body>
<h2>Dear user</h2>
<p>You are receiving this email because we received a password reset request for your account. Please use link below to change password.</p>
<a href="{!!  $linkReset !!}" >Reset password</a>
<p>This password reset link will expire in {{$count}} minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>
<p>If link does not work please copy link below and paste in browser
</p>
<p>{!! $linkReset!!}</p>
<p>Your Schedulia Team</p>
</body>
</html>
