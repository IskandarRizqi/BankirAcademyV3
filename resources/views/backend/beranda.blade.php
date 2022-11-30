<!DOCTYPE html>
<html lang="en">
@include('template.backend.head')

<body>
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- BEGIN LOADER -->
    <div id="load_screen">
        <div class="loader">
            <div class="loader-content">
                <div class="spinner-grow align-self-center"></div>
            </div>
        </div>
    </div>
    <!--  END LOADER -->

    <!--  BEGIN NAVBAR  -->
    @include('template.backend.header')
    <!--  END NAVBAR  -->

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        <!--  BEGIN SIDEBAR  -->
        @if (Auth::user()->role == 3)
        @include('backend.instructor.sidebar')
        @else
        @include('template.backend.sidebar')
        @endif
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                @if (Session::has('message'))
                <div class="alert alert-dismissible alert-info">
                    {{Session::get('message')}}
                </div>
                @endif
                {{-- @if (Session::get('success'))
                <div class="alert alert-dismissible alert-success">
                    <i class="icon-gift"></i><strong>Success!</strong>
                    {{ Session::get('success') }}
                </div>
                @endif
                @if (Session::get('error'))
                <div class="alert alert-dismissible alert-danger">
                    <i class="icon-gift"></i><strong>Failed!</strong>
                    {{ Session::get('error') }}
                </div>
                @endif --}}
                @yield('content')
            </div>
            @include('template.backend.footer')
        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->
    @include('template.backend.js')
    @yield('custom-js')

</body>

</html>