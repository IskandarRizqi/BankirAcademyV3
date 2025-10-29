<!DOCTYPE html>
<html lang="en">

<head>
    
    @include('front.layout.v3.head')
   
</head>

<body >
    {{-- <div id="loading-area"></div> --}}
    {{-- <div class="page-wraper"> --}}
        
        @include('front.layout.v3.navbar')


        <!-- Content Wrapper -->
        {{-- <main id="main">
            @if(Session::has('info'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Info!</strong>{{Session::get('info')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif --}}
            @yield('content')
        {{-- </main> --}}
        {{-- @include('admin.layout.footer') --}}

        <!-- scroll top button -->
        {{-- <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a> --}}
    </div>

    @include('front.layout.v3.script')
    @include('front.layout.v3.footer')
    @stack('scripts')

</body>

</html>