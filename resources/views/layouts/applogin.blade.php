<!DOCTYPE html>
<html lang="id">

@include('frontend.partials.head', ['bankPage' => 'login'])

<body class="auth-login-body">
    <svg height="0" style="position: absolute" width="0" aria-hidden="true">
        <symbol id="logo-ba" viewBox="0 0 64 64">
            <rect fill="#6757D9" height="64" rx="17" width="64"></rect>
            <path d="M19 13h19c8 0 13 4 13 10 0 4-2 7-6 9 5 2 8 5 8 10 0 8-6 12-15 12H19V13zm10 8v8h8c3 0 5-1 5-4s-2-4-5-4h-8zm0 16v9h9c4 0 6-2 6-5s-2-4-6-4h-9z" fill="#fff"></path>
            <path d="M14 18h5v31h-5z" fill="#00B7A8"></path>
        </symbol>
    </svg>

    @yield('content')

    @stack('frontend-scripts')
</body>

</html>
