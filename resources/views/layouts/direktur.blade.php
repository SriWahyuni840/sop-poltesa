<!DOCTYPE html>
<html>
<head>
    <title>{{ $title ?? 'Direktur' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    @yield('content')
</div>

</body>
</html>