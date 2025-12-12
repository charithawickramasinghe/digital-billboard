<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }}</title>

    <link rel="stylesheet" href="{{ asset('css/auth-layout.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

    <div class="container">
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            {{ $slot }}
        </div>
    </div>

</body>

</html>