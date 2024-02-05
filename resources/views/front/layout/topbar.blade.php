<body class="stretched" style="font-family: Cambria !important">
    @include('sweetalert::alert', ['cdn' => "https://cdn.jsdelivr.net/npm/sweetalert2@9"])
    <!-- Document Wrapper
	============================================= -->
    <style>
        .loader {
            border: 16px solid #f3f3f3;
            border-top: 16px solid #3498db;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div id="loader-loading" class="d-flex justify-content-center align-items-center"
        style="position: fixed; width: 100vw; height: 100vh; top: 0; left: 0; z-index: 9999; background: aliceblue; ">
        <div class="loader"></div>
    </div>
    <div id="wrapper" class="clearfix">
        <!-- Top Bar
		============================================= -->
        <div id="top-bar" hidden>
            <div class="container">

                <div class="row justify-content-between align-items-center">
                    <div class="col-12 col-md-auto">
                        <p class="mb-0 py-2 text-center text-md-left"><strong>Call:</strong> 1800-547-2145 |
                            <strong>Email:</strong> info@canvas.com
                        </p>
                    </div>

                    <div class="col-12 col-md-auto">
                        <div class="top-links on-click">
                            <ul class="top-links-container">
                                <li class="top-links-item"><a href="#">Login</a>
                                    <div class="top-links-section">
                                        <form id="top-login" autocomplete="off">
                                            <div class="form-group">
                                                <label>Username</label>
                                                <input type="email" class="form-control" placeholder="Email address">
                                            </div>
                                            <div class="form-group">
                                                <label>Password</label>
                                                <input type="password" class="form-control" placeholder="Password"
                                                    required="">
                                            </div>
                                            <div class="form-group form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                    id="top-login-checkbox">
                                                <label class="form-check-label" for="top-login-checkbox">Remember
                                                    Me</label>
                                            </div>
                                            <button class="btn btn-danger btn-block" type="submit">Sign in</button>
                                        </form>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- #top-bar end -->