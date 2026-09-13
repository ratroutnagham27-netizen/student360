<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Dashboard | Student360</title>
</head>
<body>
    <main>
        <h1>Teacher Dashboard</h1>

        <p>Welcome, {{ auth()->user()->name }}.</p>
        <p>Role: {{ auth()->user()->role->label() }}</p>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </main>
</body>
</html>