<!DOCTYPE html>
<html lang="en">
@include('template.backend.head')

<body>
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
        @if (Auth::user()->role!=3)
        @include('template.backend.sidebar')
        @endif
        <!--  BEGIN SIDEBAR  -->
        <!--  END SIDEBAR  -->

        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">
            <div class="layout-px-spacing">
                <div class="row layout-top-spacing">
                    @if (Session::get('success'))
                    <div class="alert alert-dismissible alert-success">
                        <i class="icon-gift"></i><strong>Success!</strong>
                        {{Session::get('success')}}
                    </div>
                    @endif
                    @if (Session::get('error'))
                    <div class="alert alert-dismissible alert-danger">
                        <i class="icon-gift"></i><strong>Failed!</strong>
                        {{Session::get('error')}}
                    </div>
                    @endif
                    @yield('content')
                </div>
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