<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Dashboard Kepala Pusat' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#f5f6fa;">

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>{{ $title ?? 'Dashboard Kepala Pusat' }}</h3>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-danger btn-sm">Logout</button>
        </form>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            @yield('content')
        </div>
    </div>
</div>

</body>
</html>