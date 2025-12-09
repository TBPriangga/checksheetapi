<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Portal Web | {{ $title }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{ asset('css/style.css')}}" rel="stylesheet">
    <style>
        input{
            text-transform: none;
        }
    </style>
</head>

<body class="gray-bg">

    <div class="ibox-content middle-box text-center loginscreen animated fadeInDown mt-5">

        <div>
            <div>
                <img src="{{asset('ajilogo.png')}}" alt="logo" width="100">
            </div>
            <h3>AJI INTERNAL PORTAL</h3>
            @include('component.message')
            <form class="m-t" role="form" id="loginForm" method="post" action="{{route('login.auth')}}"> 
            <!-- <form class="m-t" role="form" method="post" action="/login"> -->
            @csrf
                <div class="form-group">
                    <input type="text" class="form-control" name="username" autocomplete="new-password" placeholder="USERNAME" value="{{ old('username') }}" required>
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" name="password" autocomplete="new-password" placeholder="PASSWORD" required>
                </div>
                <button type="submit" id="loginButton" class="btn btn-info block full-width m-b" style="background-color:#225879">Login</button>
                {{-- <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-white btn-block" href="{{route('NewProductPortalSignupController.create')}}">Create an account</a> --}}
            </form>
            <p class="m-t"> <small>AJI INTERNAL PORAL &copy;copyright 2022</small> </p>
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src={{ asset('js/jquery-3.1.1.min.js') }}></script>
    <script src={{ asset('js/popper.min.js') }}></script>
    <script src={{ asset('js/bootstrap.js') }}></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function() {
            document.getElementById('loginButton').disabled = true;
        });
    </script>

</body>

</html>
