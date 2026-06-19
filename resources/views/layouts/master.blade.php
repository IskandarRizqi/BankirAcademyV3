<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - BlueAdmin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            overflow-x: hidden;
        }
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .bg-blue-primary { background-color: #0d6efd; }
        .bg-blue-dark { background-color: #0a58ca; }
        .text-blue { color: #0d6efd; }
    </style>
    @stack('styles')
</head>
<body>

    <div class="wrapper">
        @include('layouts.sidebar')

        <div id="content" class="d-flex flex-column">
            @include('layouts.topbar')

            <main class="container-fluid pt-4 flex-grow-1">
                @yield('content')
            </main>

            <footer class="text-center py-3 text-muted mt-auto">
                <small>&copy; {{ date('Y') }} <strong>BlueAdmin</strong>. All rights reserved.</small>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>