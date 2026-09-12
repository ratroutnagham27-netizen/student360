<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Student360</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-card {
            background: white;
            width: 100%;
            max-width: 380px;
            padding: 32px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
            text-align: center;
        }

        label {
            display: block;
            margin-top: 16px;
            margin-bottom: 6px;
        }

        input[type="email"],
        input[type="password"] {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 16px 0;
        }

        .remember label {
            margin: 0;
        }

        button {
            width: 100%;
            padding: 11px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
        }

        .errors {
            color: #b91c1c;
            background: #fee2e2;
            padding: 10px;
            border-radius: 6px;
        }
    </style>
</head>
<body>
    <main class="login-card">
        <h1>Student360</h1>
        <p>Sign in to your account</p>

        @if ($errors->any())
            <div class="errors" role="alert">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
            >

            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            >

            <div class="remember">
                <input id="remember" type="checkbox" name="remember" value="1">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>