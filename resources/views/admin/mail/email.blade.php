<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email verification </title>
</head>
<body>
    <h3>Please click on the link bellow to reset password </h3>
    {{-- <p>{{$code}}</p> --}}
    <a href="{{route('admin.reset_password')}}">Reset Password</a>
</body>
</html>