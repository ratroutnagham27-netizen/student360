<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student360 - @yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/student360.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="topbar">
        <div class="brand"><i class="bi bi-mortarboard-fill"></i> Student360</div>
        <div class="user-area">
            <span class="role-tag">{{ auth()->user()->role->value ?? ucfirst(auth()->user()->role) }}</span>
            <span class="who"><i class="bi bi-person-circle"></i> {{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                @csrf
                <button type="submit" class="btn btn-ghost"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>
    </nav>
    <main class="page-wrap">@yield('content')</main>
    <footer class="page-foot">&copy; {{ date('Y') }} Student360 - Smart Student Development Platform</footer>
    <script src="{{ asset('js/student360.js') }}"></script>
    @stack('scripts')
</body>
</html>
