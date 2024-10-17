<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Login/login.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/css/organizer/Login/images/favicon.png') }}">

    <title>Login | Technowiz Admin Console </title>
</head>

<body>
    <div class="mainContainer">
        <img class="mainLogoImage" src="{{ asset('assets/css/organizer/Login/images/logo.png') }}" alt="">
        <h1 class="mainHeading">Admin Console</h1>
        <div class="loginForm">
            <h1 class="loginHeading">Log in</h1>
            <form action="{{ route('organizer.login') }}" method="POST">
                @csrf
                <input type="text" name="username" placeholder="Enter Username" required autocomplete="off"
                    value="{{ old('username') }}">
                {{-- @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror --}}

                <input type="password" name="password" placeholder="Enter Password" required
                    autocomplete="new-password">
                @error('username')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                @if (session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif

                <button class="loginButton">Login</button>
            </form>
        </div>
    </div>
</body>

</html>
