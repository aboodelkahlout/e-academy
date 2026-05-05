<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <title>Teacher SignUp</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        html, body {
            height: 100%;
            width: 100%;
            display: grid;
            place-items: center;
            background: linear-gradient(to right, #003366, #004080, #0059b3, #0073e6);
        }

        .wrapper {
            width: 400px;
            padding: 30px;
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 15px 20px rgba(0,0,0,0.1);
        }

        .title {
            font-size: 30px;
            font-weight: 600;
            text-align: center;
            margin-bottom: 20px;
        }

        form .field {
            margin-top: 15px;
        }

        form .field input {
            width: 100%;
            height: 45px;
            padding: 0 15px;
            border-radius: 10px;
            border: 1px solid lightgrey;
            font-size: 16px;
        }

        form .field input:focus {
            border-color: #1a75ff;
            outline: none;
        }

        .text-danger {
            color: #ff4d4f;
            font-size: 13px;
            margin-top: 5px;
        }

        .btn {
            position: relative;
            overflow: hidden;
            margin-top: 20px;
            height: 45px;
        }

        .btn-layer {
            position: absolute;
            left: -100%;
            width: 300%;
            height: 100%;
            border-radius: 10px;
            background: linear-gradient(to right, #003366, #004080, #0059b3, #0073e6);
            transition: all 0.4s ease;
        }

        .btn:hover .btn-layer {
            left: 0;
        }

        .btn input[type="submit"] {
            position: relative;
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 10px;
            background: none;
            color: #fff;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
        }

        .login-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            text-decoration: none;
            color: #1a75ff;
        }

        .login-link:hover {
            text-decoration: underline;
        }

         .input-eye{
        position: relative;
    }

    .show{
        position: absolute;
        top: 14px;
        right: 15px;
        cursor: pointer;
    }

    </style>
</head>
<body>
    <div class="wrapper">
        <div class="title">Teacher Signup</div>
   <form method="POST" action="{{ route('store.teachers') }}" enctype="multipart/form-data">
    @csrf

    <div class="field">
        <input type="text" name="name" value="{{ old('name') }}" placeholder="Name">
    </div>
    @error('name')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    <div class="field">
        <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
    </div>
    @error('email')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    <div class="field input-eye">
        <i class="fas fa-eye show"></i>
        <input type="password" name="password" placeholder="Password">
    </div>
    @error('password')
        <small class="text-danger">{{ $message }}</small>
    @enderror

    <div class="field">
        <input type="password" name="password_confirmation" placeholder="Confirm password">
    </div>

      <div class="field">
        <input type="file" name="cover">
    </div>

    <div class="field btn">
        <div class="btn-layer"></div>
        <input type="submit" value="Signup">
    </div>
</form>
        <a href="{{route('login') }}" class="login-link">Already have an account? Login</a>
    </div>
<script>
    let pass = document.querySelector('input[name=password]');
     let eye = document.querySelector('.show');
     let is_show = true
     eye.onclick = function(){
        if (is_show == true) {
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
            pass.type="text";
            is_show = false;
        }else{
             eye.classList.remove('fa-eye-slash');
             eye.classList.add('fa-eye');
             pass.type="password";
             is_show = true;
        }
     }
</script>
</body>
</html>
