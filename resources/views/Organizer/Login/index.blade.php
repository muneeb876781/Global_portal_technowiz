<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/css/organizer/Login/login.css') }}">
    <title>Login | Technowiz Universal Portal</title>
</head>

<body>
    <div class="mainContainer">
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
