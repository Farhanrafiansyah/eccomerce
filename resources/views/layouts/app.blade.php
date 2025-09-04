<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Toko Online')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootswatch Pulse (ungu) -->
    <link href="https://cdn.jsdelivr.net/npm/bootswatch@5.3.0/dist/pulse/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    @include('partials.navbar')

    <div class="container mt-5">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
