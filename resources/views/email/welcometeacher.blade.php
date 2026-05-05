<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>email verfiy</title>
</head>
<body>
<h3>{{$info['name']}}</h3>
<p>we have been create your account with this data</p>
<p>click on this button to verfiy your account</p>
<p>this is your email{{$info['email']}} and this is your password {{$info['password']}}</p>
<a href="{{route('verfiy.email',  $info['id']  )}}">verfiy your email</a>
</body>
</html>
