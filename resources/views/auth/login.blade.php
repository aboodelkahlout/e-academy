<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login Now</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

html, body {
    height: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(#032140, #0059b3, #0073e6);
}

.wrapper {
    width: 400px;
    padding: 40px 30px;
    background: #ffffff;
    border-radius: 15px;
    box-shadow: 0 15px 25px rgba(0,0,0,0.2);
}

.title {
    font-size: 28px;
    font-weight: 600;
    text-align: center;
    margin-bottom: 25px;
    color: #032140;
}

form .field {
    margin-bottom: 20px;
    position: relative;
}

form .field input {
    width: 100%;
    height: 50px;
    padding: 0 15px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 10px;
    transition: all 0.3s ease;
}

form .field input:focus {
    border-color: #0073e6;
    box-shadow: 0 0 5px rgba(0,115,230,0.3);
    outline: none;
}

.text-danger {
    color: #ff4d4f;
    font-size: 13px;
    margin-top: 5px;
}

.remember-me {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.remember-me input[type="checkbox"] {
    margin-right: 8px;
}

.pass-link {
    margin-bottom: 20px;
}

.pass-link a {
    color: #0073e6;
    text-decoration: none;
    font-size: 14px;
}

.pass-link a:hover {
    text-decoration: underline;
}

.field.btn {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    height: 50px;
}

.btn-layer {
    position: absolute;
    top: 0;
    left: -100%;
    width: 300%;
    height: 100%;
    background: linear-gradient(90deg, #003366,#004080,#0059b3,#0073e6);
    transition: all 0.4s ease;
    border-radius: 10px;
}

.btn:hover .btn-layer {
    left: 0;
}

.btn input[type="submit"] {
    position: relative;
    width: 100%;
    height: 100%;
    border: none;
    background: none;
    color: #fff;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    z-index: 1;
}

.signup-link, .login-link {
    display: block;
    text-align: center;
    margin-top: 10px;
    font-size: 14px;
    color: #0073e6;
    text-decoration: none;
}

.signup-link:hover, .login-link:hover {
    text-decoration: underline;
}

.input-eye {
    position: relative;
}

.show {
    position: absolute;
    top: 14px;
    right: 15px;
    cursor: pointer;
    color: #888;
    transition: color 0.3s;
}

.show:hover {
    color: #0073e6;
}

/* Google button */
.btn-light {
    width: 100%;
    margin-top: 15px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    font-weight: 500;
    color: #333;
    border-radius: 10px;
}



</style>
</head>
<body>
<div class="wrapper">
    @if(session('msg'))
<script>
toastr.{{ session('msg.type') }}("{{ session('msg.message') }}");
</script>
@endif
    <div class="title">Login</div>
    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div class="field">
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address">
            @error('email')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="field input-eye">
            <i class="fas fa-eye show"></i>
            <input type="password" name="password" placeholder="Password">
            @error('password')
            <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-me">
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Remember me</label>
        </div>



        <div class="pass-link"><a href="{{route('password.request')}}">Forgot password?</a></div>

        <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" value="Login">
        </div>

        <a href="{{ route('register') }}" class="signup-link">Not a member? Signup now</a>
        <a href="{{route('register.teacher')}}" class="signup-link">are you teacher ? signup now </a>
    </form>
   <a href="{{ route('social.login') }}"
   class="btn btn-light border d-flex align-items-center justify-content-center gap-2">
    <i class="fab fa-google text-danger"></i>
    <span class="fw-semibold">Sign in with Google</span>
</a>

<!-- <a href="{{ route('facebook.login') }}" class="btn btn-primary">
    Sign In with facebook
</a> -->

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

const Toast = Swal.mixin({
  toast: true,
  position: "top-end",
  showConfirmButton: false,
  timer: 3000,
  timerProgressBar: true,
  didOpen: (toast) => {
    toast.onmouseenter = Swal.stopTimer;
    toast.onmouseleave = Swal.resumeTimer;
  }
});


@if (session('msg'))
Toast.fire({
  icon: "{{session('type')}}",
  title: "{{session('msg')}}"
});
@endif


</script>
</body>
</html>
