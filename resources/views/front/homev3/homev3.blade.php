
    
  {{-- @include('front.layout.headv3')
  @include('front.layout.topbar')
  @include(env('CUSTOM_HEADER', 'front.layout.headerv3')) --}}

@extends('front.layout.v3.main')
@section('content') 

        <section class="p-0 bg-dark-gray">
            <div class="swiper full-screen bg-dark-gray ipad-top-space-margin md-h-400px sm-h-500px swiper-number-pagination-style-02 magic-cursor light magic-cursor-vertical lg-no-parallax" data-slider-options='{ "slidesPerView": 1, "direction": "horizontal", "loop": true, "parallax": true, "speed": 1000, "pagination": { "el": ".swiper-number", "clickable": true }, "autoplay": { "delay": 40000, "disableOnInteraction": false },  "keyboard": { "enabled": true, "onlyInViewport": true }, "breakpoints": { "1199": { "direction": "vertical" }}, "effect": "slide" }' data-number-pagination="1">
                <div class="swiper-wrapper">
                    <!-- start slider item -->
                    <div class="swiper-slide overflow-hidden">
                        <div class="cover-background position-absolute top-0 start-0 w-100 h-100" data-swiper-parallax="500" style="background-image:url('FE/images/bg.jpeg');">
                            <div class="opacity-light bg-dark-gray"></div>
                            <div class="container h-100">
                                <div class="row align-items-center h-100 justify-content-center">
                                    <div class="col-md-10 position-relative text-white d-flex flex-column justify-content-center h-100 text-center">  
                                        <div class="alt-font fs-110 xs-fs-80 lh-100 mb-5 xs-mb-35px ls-minus-4px xs-ls-minus-2px text-shadow-double-large transform-origin-right" data-anime='{ "el": "childs", "rotateX": [90, 0], "opacity": [0,1], "staggervalue": 150, "easing": "easeOutQuad" }'>
                                            <span class="d-inline-block">Professional</span>
                                            <span class="d-inline-block fw-600">consulting</span>
                                        </div>
                                        <div data-anime='{  "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 300, "staggervalue": 300, "easing": "easeOutQuad" }'>
                                            <a href="demo-consulting-contact.html" class="btn btn-base-color btn-box-shadow btn-large btn-round-edge">Let's work together</a>
                                        </div>
                                        <div data-anime='{ "opacity": [0, 1], "duration": 500, "delay": 1000, "easing": "easeOutQuad" }' class="fs-20 alt-font position-absolute lg-position-relative left-0px right-0px bottom-0 mb-8 lg-mt-40px lg-mb-0 sm-mt-25px w-100 text-shadow-double-large">Request a free <a href="demo-consulting-contact.html" class="text-decoration-line-bottom text-white fw-500">business consulting!</a></div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- end slider item -->
                    <!-- start slider item -->
                    <div class="swiper-slide overflow-hidden">
                        <div class="cover-background position-absolute top-0 start-0 w-100 h-100" data-swiper-parallax="500" style="background-image:url('FE/images/bg1.jpeg');">
                            <div class="opacity-light bg-dark-gray"></div>
                            <div class="container h-100">
                                <div class="row align-items-center h-100 justify-content-center">
                                    <div class="col-md-10 position-relative text-white d-flex flex-column justify-content-center h-100 text-center">  
                                        <div class="alt-font fs-110 xs-fs-80 lh-100 mb-5 xs-mb-35px ls-minus-4px xs-ls-minus-2px text-shadow-double-large" data-anime='{ "el": "childs", "rotateX": [90, 0], "opacity": [0,1], "staggervalue": 150, "easing": "easeOutQuad" }'>
                                            <span class="d-inline-block">Contribute</span><br>
                                            <span class="fw-600 d-inline-block">guidance</span>
                                        </div> 
                                        <div data-anime='{  "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 300, "staggervalue": 300, "easing": "easeOutQuad" }'><a href="demo-consulting-contact.html" class="btn btn-base-color btn-box-shadow btn-large btn-round-edge">Let's work together</a></div>
                                        <div data-anime='{ "opacity": [0, 1], "duration": 500, "delay": 1000, "easing": "easeOutQuad" }' class="fs-20 alt-font position-absolute lg-position-relative left-0px right-0px bottom-0 mb-8 lg-mt-40px lg-mb-0 sm-mt-25px w-100 text-shadow-double-large">Discover our <a href="demo-consulting-process.html" class="text-decoration-line-bottom text-white fw-500">business process!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end slider item -->
                    <!-- start slider item -->
                    <div class="swiper-slide overflow-hidden">
                        <div class="cover-background position-absolute top-0 start-0 w-100 h-100" data-swiper-parallax="500" style="background-image:url('FE/images/bg2.jpeg');">
                            <div class="opacity-light bg-dark-gray"></div>
                            <div class="container h-100">
                                <div class="row align-items-center h-100 justify-content-center">
                                    <div class="col-md-10 position-relative text-white d-flex flex-column justify-content-center h-100 text-center">  
                                        <div class="alt-font fs-110 xs-fs-80 lh-100 mb-5 xs-mb-35px ls-minus-4px xs-ls-minus-2px text-shadow-double-large" data-anime='{ "el": "childs", "rotateX": [90, 0], "opacity": [0,1], "staggervalue": 150, "easing": "easeOutQuad" }'>
                                            <span class="d-inline-block">Business</span><br>
                                            <span class="fw-600 d-inline-block">strategies</span>
                                        </div> 
                                        <div data-anime='{  "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 300, "staggervalue": 300, "easing": "easeOutQuad" }'><a href="demo-consulting-contact.html" class="btn btn-base-color btn-box-shadow btn-large btn-round-edge">Let's work together</a></div>
                                        <div data-anime='{ "opacity": [0, 1], "duration": 500, "delay": 1000, "easing": "easeOutQuad" }' class="fs-20 alt-font position-absolute lg-position-relative left-0px right-0px bottom-0 mb-8 lg-mt-40px lg-mb-0 sm-mt-25px w-100 text-shadow-double-large">Become a part of <a href="demo-consulting-company.html" class="text-decoration-line-bottom text-white fw-500">business venture!</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end slider item -->
                </div>
                <!-- start slider pagination -->
                <div class="swiper-pagination container swiper-pagination-clickable swiper-pagination-bullets-right swiper-number"></div> 
                <!-- end slider pagination --> 
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="position-relative overflow-hidden">
            <div id="particles-01" data-particle="true" data-particle-options='{"particles": {"number": {"value": 5,"density": {"enable": true,"value_area": 1000}},"color":{"value":["#b7b9be", "#dd6531"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"move": {"enable": true,"speed":2,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}' class="position-absolute h-100 top-0 left-0 z-index-minus-1"></div>
            <div class="container">
                <div class="row row-cols-1 row-cols-lg-3 row-cols-md-2 justify-content-center" data-anime='{ "el": "childs", "rotateZ": [5, 0], "translateY": [30, 0], "opacity": [0,1], "duration": 600, "delay": 0, "staggervalue": 150, "easing": "easeOutQuad" }'>
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-01 mb-50px sm-mb-40px">
                        <div class="feature-box feature-box-left-icon last-paragraph-no-margin">
                            <div class="feature-box-icon">
                                <img src="FE/images/images-demo-consulting-icon-01.png" alt="">
                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block alt-font text-dark-gray fw-600 mb-5px fs-20">Innovative ideas</span>
                                <p class="w-90 md-w-100">Lorem ipsum simply dummy text printing typesetting.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end features box item -->
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-01 mb-50px sm-mb-40px">
                        <div class="feature-box feature-box-left-icon last-paragraph-no-margin">
                            <div class="feature-box-icon">
                                <img src="FE/images/images-demo-consulting-icon-02.png" alt="">
                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block alt-font text-dark-gray fw-600 mb-5px fs-20">Expertise strategy</span>
                                <p class="w-90 md-w-100">Lorem ipsum simply dummy text printing typesetting.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end features box item -->
                    <!-- start features box item -->
                    <div class="col icon-with-text-style-01 mb-50px sm-mb-40px">
                        <div class="feature-box feature-box-left-icon last-paragraph-no-margin">
                            <div class="feature-box-icon">
                                <img src="FE/images/images-demo-consulting-icon-03.png" alt="">
                            </div>
                            <div class="feature-box-content">
                                <span class="d-inline-block alt-font text-dark-gray fw-600 mb-5px fs-20">Financial planning</span>
                                <p class="w-90 md-w-100">Lorem ipsum simply dummy text printing typesetting.</p>
                            </div>
                        </div>
                    </div>
                    <!-- end features box item -->
                </div>
                <div class="row align-items-center mt-4 lg-mt-2 mb-50px lg-mb-0">
                    <div class="col-lg-6 position-relative md-mb-70px">
                        <div class="w-75 overflow-hidden position-relative xs-w-80 border-radius-4px" data-anime='{ "effect": "slide", "direction": "lr", "color": "#dd6531", "duration": 1000, "delay": 0 }'>
                            <img class="w-100" src="FE/images/images-demo-consulting-01.jpg" alt="">
                        </div>
                        <div class="border-radius-4px position-absolute right-minus-15px md-right-15px bottom-minus-50px w-55 md-w-50 overflow-hidden" data-bottom-top="transform: translateY(50px)" data-top-bottom="transform: translateY(-50px)" data-anime='{ "effect": "slide", "direction": "rl", "color": "#292d36", "duration": 1000, "delay": 500 }'>
                            <img class="w-100" src="FE/images/images-demo-consulting-02.jpg" alt="">
                        </div>
                    </div>
                    <div class="col-lg-5 offset-lg-1 md-mt-30px" data-anime='{ "opacity": [0, 1], "duration": 600, "delay": 0, "staggervalue": 150, "easing": "easeOutCirc" }'>
                        <span class="fs-20 mb-15px text-dark-gray fw-600 d-inline-block">Company's vision</span>
                        <h2 class="alt-font fw-600 text-dark-gray ls-minus-2px mb-25px">Scalable business for startups.</h2>
                        <p class="w-80 lg-w-100 mb-35px sm-mb-25px">Lorem ipsum dolor sit amet consectetur elit adipiscing elit do eiusmod tempor incididunt ut labore et dolore magna ut enim.</p> 
                        <div class="d-inline-block">
                            <a href="demo-consulting-company.html" class="btn btn-medium btn-dark-gray btn-box-shadow me-25px btn-round-edge">About company</a>
                            <a href="demo-consulting-process.html" class="btn btn-link btn-large text-dark-gray xs-mt-15px xs-mb-15px">How we work</a>
                        </div>
                        <div class="row align-items-center mt-50px sm-mt-40px">
                            <div class="col-auto col-lg-4 border-end border-color-extra-medium-gray text-center"><h1 class="text-dark-gray fw-700 mb-0">4.9</h1></div>
                            <div class="col-7 ms-15px md-ms-0">
                                <div class="review-star-icon fs-18">
                                    <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                                </div>
                                <span class="text-dark-gray d-block fw-500 fs-18">2,488 Genuine rating</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="bg-gradient-very-light-gray ps-7 pe-7 xxl-ps-3 xxl-pe-3 xs-px-0">
            <div class="container-fluid"> 
                <div class="row justify-content-center mb-3">
                    <div class="col-xl-5 col-lg-7 col-md-8 text-center" data-anime='{ "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="fw-600 ls-1px fs-16 alt-font d-inline-block text-uppercase mb-5px text-base-color">Innovative solutions</span>
                        <h2 class="alt-font text-dark-gray fw-600 ls-minus-2px">Consulting services</h2>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-xl-4 row-cols-md-2 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "translateX": [30, 0], "opacity": [0,1], "duration": 800, "delay": 200, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <!-- start interactive banner item -->
                    <div class="col interactive-banner-style-05 lg-mb-30px position-relative z-index-1">
                        <div class="atropos" data-atropos data-atropos-perspective="1450">
                            <a href="demo-consulting-services-details.html" class="position-absolute z-index-1 top-0px left-0px h-100 w-100"></a>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <figure class="m-0 hover-box border-radius-4px overflow-hidden position-relative" data-atropos-offset="3">
                                            <img class="w-100" src="FE/images/images-demo-consulting-03.jpg" alt="">
                                            <figcaption class="d-flex flex-column align-items-start justify-content-center position-absolute left-0px top-0px w-100 h-100 z-index-1 p-15 xl-p-12 last-paragraph-no-margin">
                                                <div class="mb-auto bg-base-color fw-500 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-13">Flexible</div>
                                                <span class="alt-font text-white fw-500 fs-26 sm-lh-26 xs-lh-28 sm-mb-5px">Audit assurance</span>
                                                <p class="text-white opacity-6 fs-18">Innovative solutions</p>
                                                <div class="position-absolute left-0px top-0px w-100 h-100 bg-gradient-gray-light-dark-transparent z-index-minus-1 opacity-9"></div>
                                                <div class="box-overlay bg-gradient-gray-light-dark-transparent z-index-minus-1"></div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- end interactive banner item --> 
                    <!-- start interactive banner item -->
                    <div class="col interactive-banner-style-05 lg-mb-30px position-relative z-index-1">
                        <div class="atropos" data-atropos data-atropos-perspective="1450">
                            <a href="demo-consulting-services-details.html" class="position-absolute z-index-1 top-0px left-0px h-100 w-100"></a>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <figure class="m-0 hover-box border-radius-4px overflow-hidden position-relative" data-atropos-offset="3">
                                            <img class="w-100" src="FE/images/images-demo-consulting-04.jpg" alt="">
                                            <figcaption class="d-flex flex-column align-items-start justify-content-center position-absolute left-0px top-0px w-100 h-100 z-index-1 p-15 xl-p-12 last-paragraph-no-margin">
                                                <div class="mb-auto bg-base-color fw-500 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-13">Diversity</div>
                                                <span class="alt-font text-white fw-500 fs-26 sm-lh-26 xs-lh-28">Financial advisory</span>
                                                <p class="text-white opacity-6 fs-18">Business consalting</p>
                                                <div class="position-absolute left-0px top-0px w-100 h-100 bg-gradient-gray-light-dark-transparent z-index-minus-1 opacity-9"></div>
                                                <div class="box-overlay bg-gradient-gray-light-dark-transparent z-index-minus-1"></div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div> 
                    <!-- end interactive banner item --> 
                    <!-- start interactive banner item -->
                    <div class="col interactive-banner-style-05 sm-mb-30px position-relative z-index-1">
                        <div class="atropos" data-atropos data-atropos-perspective="1450">
                            <a href="demo-consulting-services-details.html" class="position-absolute z-index-1 top-0px left-0px h-100 w-100"></a>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <figure class="m-0 hover-box border-radius-4px overflow-hidden position-relative" data-atropos-offset="3">
                                            <img class="w-100" src="FE/images/images-demo-consulting-05.jpg" alt="">
                                            <figcaption class="d-flex flex-column align-items-start justify-content-center position-absolute left-0px top-0px w-100 h-100 z-index-1 p-15 xl-p-12 last-paragraph-no-margin">
                                                <div class="mb-auto bg-base-color fw-500 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-13">Inclusion</div>
                                                <span class="alt-font text-white fw-500 fs-26 sm-lh-26 xs-lh-28">Business analytics</span>
                                                <p class="text-white opacity-6 fs-18">Driving sustainable</p>
                                                <div class="position-absolute left-0px top-0px w-100 h-100 bg-gradient-gray-light-dark-transparent z-index-minus-1 opacity-9"></div>
                                                <div class="box-overlay bg-gradient-gray-light-dark-transparent z-index-minus-1"></div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                    <!-- end interactive banner item --> 
                    <!-- start interactive banner item -->
                    <div class="col interactive-banner-style-05 position-relative z-index-1">
                        <div class="atropos" data-atropos data-atropos-perspective="1450">
                            <a href="demo-consulting-services-details.html" class="position-absolute z-index-1 top-0px left-0px h-100 w-100"></a>
                            <div class="atropos-scale">
                                <div class="atropos-rotate">
                                    <div class="atropos-inner">
                                        <figure class="m-0 hover-box border-radius-4px overflow-hidden position-relative" data-atropos-offset="3">
                                            <img class="w-100" src="FE/images/images-demo-consulting-06.jpg" alt="">
                                            <figcaption class="d-flex flex-column align-items-start justify-content-center position-absolute left-0px top-0px w-100 h-100 z-index-1 p-15 xl-p-12 last-paragraph-no-margin">
                                                <div class="mb-auto bg-base-color fw-500 text-white text-uppercase border-radius-30px ps-20px pe-20px fs-13">Strategy</div>
                                                <span class="alt-font text-white fw-500 fs-26 sm-lh-26 xs-lh-28">Middle marketing</span>
                                                <p class="text-white opacity-6 fs-18">Inclusive growth</p>
                                                <div class="position-absolute left-0px top-0px w-100 h-100 bg-gradient-gray-light-dark-transparent z-index-minus-1 opacity-9"></div>
                                                <div class="box-overlay bg-gradient-gray-light-dark-transparent z-index-minus-1"></div>
                                            </figcaption>
                                        </figure>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div> 
                    <!-- end interactive banner item --> 
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-0 position-relative">
            <div id="particles-02" data-particle="true" data-particle-options='{"particles": {"number": {"value": 5,"density": {"enable": true,"value_area": 1000}},"color":{"value":["#b7b9be", "#dd6531"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"move": {"enable": true,"speed":2,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}' class="position-absolute h-100 top-0 left-0 z-index-minus-1"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 md-mb-50px sm-mb-30px">
                        <h2 class="alt-font fw-600 text-dark-gray ls-minus-2px">Highly flexible pricing options.</h2>
                        <p class="w-80 lg-w-100 mb-30px sm-mb-25px">Lorem ipsum dolor sit amet consectetur adipiscing elit do eiusmod tempor.</p> 
                        <a href="#" class="btn btn-small btn-dark-gray btn-box-shadow btn-round-edge">All pricing plans</a>
                    </div>
                    <div class="col-xl-5 col-lg-6 offset-xl-2 offset-lg-1" data-anime='{"opacity": [0,1], "duration": 600, "delay":200, "staggervalue": 200, "easing": "easeOutQuad" }'>
                        <div class="accordion accordion-style-02" id="accordion-style-02" data-active-icon="icon-feather-minus" data-inactive-icon="icon-feather-plus">
                            <!-- start accordion item -->
                            <div class="accordion-item active-accordion">
                                <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-01" aria-expanded="true" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray">
                                            <i class="feather icon-feather-minus"></i><span class="fw-600 fs-20">Unique and bold website design</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-01" class="accordion-collapse collapse show" data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion item -->
                            <!-- start accordion item -->
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-extra-medium-gray">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-02" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray">
                                            <i class="feather icon-feather-plus"></i><span class="fw-600 fs-20">We're ready to start now</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-02" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-light-medium-gray">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion item -->
                            <!-- start accordion item -->
                            <div class="accordion-item">
                                <div class="accordion-header border-bottom border-color-transparent">
                                    <a href="#" data-bs-toggle="collapse" data-bs-target="#accordion-style-02-03" aria-expanded="false" data-bs-parent="#accordion-style-02">
                                        <div class="accordion-title mb-0 position-relative text-dark-gray">
                                            <i class="feather icon-feather-plus"></i><span class="fw-600 fs-20">Something for everyone</span>
                                        </div>
                                    </a>
                                </div>
                                <div id="accordion-style-02-03" class="accordion-collapse collapse" data-bs-parent="#accordion-style-02">
                                    <div class="accordion-body last-paragraph-no-margin border-bottom border-color-transparent">
                                        <p>Lorem ipsum dolor sit amet consectetur adipiscing elit sed do eiusmod tempor incididunt.</p>
                                    </div>
                                </div>
                            </div>
                            <!-- end accordion item -->
                        </div>
                    </div>
                </div>
 
              
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="position-relative overflow-hidden py-0">
            <div class="skrollr-parallax mx-auto pt-7 pb-7 md-pt-12 md-pb-12" data-bottom-top="width: 63%" data-center-top="width: 100%;" data-parallax-background-ratio="0.5" style="background-image: url('FE/images/demo-consulting-parallax.jpg')">
                <div class="opacity-extra-medium bg-gradient-black-dark-orange"></div>
                <div class="container">
                    <div class="row justify-content-center align-items-center mb-5">
                        <div class="col-xl-9 col-lg-10 text-center position-relative last-paragraph-no-margin parallax-scrolling-style-2">
                            <a href="https://www.youtube.com/watch?v=cfXHhfNy7tU" class="position-relative d-inline-block text-center rounded-circle border border-3 border-color-transparent-white-very-light video-icon-box video-icon-extra-large popup-youtube mb-5">
                                <span>
                                    <span class="video-icon">
                                        <i class="fa-solid fa-play text-white"></i> 
                                    </span>
                                </span>
                            </a>
                            <span class="opacity-6 ls-2px text-uppercase alt-font text-white d-block mb-2 fw-500">Supporting your business goal</span>
                            <h1 class="text-white fw-500 alt-font ls-minus-2px text-shadow-double-large">Some of the worldwide clients we've helped.</h1>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 text-center justify-content-center clients-style-06 position-relative">
                        <!-- start client item -->
                        <div class="col md-mb-45px">
                            <div class="client-box">
                                <a href="#"><img src="FE/images/images-logo-envato-white.svg" class="h-45px" alt=""></a>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col md-mb-45px">
                            <div class="client-box">
                                <a href="#"><img src="FE/images/images-logo-less-white.svg" class="h-45px" alt=""></a>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col xs-mb-45px">
                            <div class="client-box">
                                <a href="#"><img src="FE/images/images-logo-pingdom-white.svg" class="h-45px" alt=""></a>
                            </div>
                        </div>
                        <!-- end client item -->
                        <!-- start client item -->
                        <div class="col">
                            <div class="client-box">
                                <a href="#"><img src="FE/images/images-logo-google-white.svg" class="h-45px" alt=""></a>
                            </div>
                        </div>
                        <!-- end client item -->
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="position-relative">
            <div id="particles-03" data-particle="true" data-particle-options='{"particles": {"number": {"value": 5,"density": {"enable": true,"value_area": 1000}},"color":{"value":["#b7b9be", "#dd6531"]},"shape": {"type": "circle","stroke":{"width":0,"color":"#000000"}},"opacity": {"value": 0.5,"random": false,"anim": {"enable": false,"speed": 1,"sync": false}},"size": {"value": 8,"random": true,"anim": {"enable": false,"sync": true}},"move": {"enable": true,"speed":2,"direction": "right","random": false,"straight": false}},"interactivity": {"detect_on": "canvas","events": {"onhover": {"enable": false,"mode": "repulse"},"onclick": {"enable": false,"mode": "push"},"resize": true}},"retina_detect": false}' class="position-absolute h-100 top-0 left-0 z-index-minus-1"></div>
            <div class="container">
                <div class="row justify-content-center mb-3">
                    <div class="col-lg-7 text-center" data-anime='{  "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="fw-600 ls-1px fs-16 alt-font mb-5px d-inline-block text-uppercase text-base-color">Meet our people</span>
                        <h2 class="alt-font text-dark-gray fw-600 ls-minus-2px">Leading experts</h2>
                    </div>
                </div>
                <div class="row row-cols-1 row-cols-lg-4 row-cols-sm-2 justify-content-center" data-anime='{ "el": "childs", "translateY": [30, 0], "opacity": [0,1], "duration": 800, "delay":0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                    <!-- start team member item -->
                    <div class="col text-center team-style-05 md-mb-40px">
                        <div class="position-relative border-radius-4px overflow-hidden mb-30px last-paragraph-no-margin">
                            <img src="FE/images/images-team-08.jpg" alt="">
                            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-40px lg-p-30px team-content bg-gradient-dark-orange-transparent">
                                <div class="social-icon fs-20">
                                    <a href="https://www.facebook.com/" target="_blank" class="text-white"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="http://www.dribbble.com" target="_blank" class="text-white"><i class="fa-brands fa-dribbble"></i></a>
                                    <a href="https://www.twitter.com/" target="_blank" class="text-white"><i class="fa-brands fa-twitter"></i></a>
                                </div>                                
                            </div>
                        </div>
                        <div class="alt-font fw-600 text-dark-gray lh-22 fs-18">Bryan Jonhson</div>
                        <span>Director</span>
                    </div>
                    <!-- end team member item -->
                    <!-- start team member item -->
                    <div class="col text-center team-style-05 md-mb-40px">
                        <div class="position-relative border-radius-4px overflow-hidden mb-30px last-paragraph-no-margin">
                            <img src="FE/images/images-team-09.jpg" alt="">
                            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-40px team-content bg-gradient-dark-orange-transparent">
                                <div class="social-icon fs-20">
                                    <a href="https://www.facebook.com/" target="_blank" class="text-white"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="http://www.dribbble.com" target="_blank" class="text-white"><i class="fa-brands fa-dribbble"></i></a>
                                    <a href="https://www.twitter.com/" target="_blank" class="text-white"><i class="fa-brands fa-twitter"></i></a>
                                </div>                              
                            </div>
                        </div>
                        <div class="alt-font fw-600 text-dark-gray lh-22 fs-18">Jeremy Dupont</div>
                        <span>Specialist</span>
                    </div>
                    <!-- end team member item -->   
                    <!-- start team member item --> 
                    <div class="col text-center team-style-05 xs-mb-40px">
                        <div class="position-relative border-radius-4px overflow-hidden mb-30px last-paragraph-no-margin">
                            <img src="FE/images/images-team-10.jpg" alt="">
                            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-40px team-content bg-gradient-dark-orange-transparent">
                                <div class="social-icon fs-20">
                                    <a href="https://www.facebook.com/" target="_blank" class="text-white"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="http://www.dribbble.com" target="_blank" class="text-white"><i class="fa-brands fa-dribbble"></i></a>
                                    <a href="https://www.twitter.com/" target="_blank" class="text-white"><i class="fa-brands fa-twitter"></i></a>
                                </div>                               
                            </div>
                        </div>
                        <div class="alt-font fw-600 text-dark-gray lh-22 fs-18">Matthew Taylor</div>
                        <span>Manager</span>
                    </div>
                    <!-- end team member item -->
                    <!-- start team member item --> 
                    <div class="col text-center team-style-05">
                        <div class="position-relative border-radius-4px overflow-hidden mb-30px last-paragraph-no-margin">
                            <img src="FE/images/images-team-11.jpg" alt="">
                            <div class="w-100 h-100 d-flex flex-column justify-content-center align-items-center p-40px team-content bg-gradient-dark-orange-transparent">
                                <div class="social-icon fs-20">
                                    <a href="https://www.facebook.com/" target="_blank" class="text-white"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="http://www.dribbble.com" target="_blank" class="text-white"><i class="fa-brands fa-dribbble"></i></a>
                                    <a href="https://www.twitter.com/" target="_blank" class="text-white"><i class="fa-brands fa-twitter"></i></a>
                                </div>                               
                            </div>
                        </div>
                        <div class="alt-font fw-600 text-dark-gray lh-22 fs-18">Johncy Parker</div>
                        <span>Consultant</span>
                    </div>
                    <!-- end team member item -->
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="bg-very-light-gray"> 
            <div class="container">
                <div class="row justify-content-center mb-2">
                    <div class="col-lg-7 text-center" data-anime='{ "opacity": [0,1], "duration": 800, "delay": 0, "staggervalue": 300, "easing": "easeOutQuad" }'>
                        <span class="fw-600 ls-1px fs-16 alt-font d-inline-block text-uppercase text-base-color">Business news</span>
                        <h2 class="alt-font text-dark-gray fw-600 ls-minus-2px">Latest news</h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 p-md-0">
                        <ul class="blog-grid blog-wrapper grid-loading grid grid-3col xl-grid-3col lg-grid-3col md-grid-2col sm-grid-2col xs-grid-1col gutter-extra-large" data-anime='{ "el": "childs", "translateY": [50, 0], "opacity": [0,1], "duration": 600, "delay":100, "staggervalue": 300, "easing": "easeOutQuad" }'>
                            <li class="grid-sizer">
                            <!-- start blog item -->
                            </li><li class="grid-item">
                                <div class="card border-0 border-radius-4px box-shadow-quadruple-large">
                                    <div class="blog-image">
                                        <a href="demo-consulting-blog-single-modern.html" class="d-block"><img src="FE/images/images-demo-consulting-blog-01.jpg" alt=""></a>
                                    </div>
                                    <div class="card-body p-13 md-p-11">
                                        <a href="demo-consulting-blog-single-modern.html" class="card-title mb-15px alt-font fw-600 fs-20 text-dark-gray d-inline-block">Build up healthy habits and strong peaceful life</a>
                                        <p>Lorem ipsum has been industry standard dummy text ever...</p>
                                        <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-16">
                                            <div class="me-auto">
                                                <span class="blog-date d-inline-block">30 August 2021</span>
                                                <div class="d-inline-block author-name">By <a href="demo-consulting-news.html" class="text-dark-gray text-decoration-line-bottom fw-600">Den viliamson</a></div>
                                            </div>
                                            <div class="like-count fs-15 fw-600">
                                                <a href="demo-consulting-blog-single-modern.html"><i class="fa-regular fa-heart text-base-color"></i><span class="text-dark-gray align-middle">65</span></a>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- end blog item -->
                            <!-- start blog item -->
                            <li class="grid-item">
                                <div class="card border-0 border-radius-4px box-shadow-quadruple-large">
                                    <div class="blog-image">
                                        <a href="demo-consulting-blog-single-modern.html" class="d-block"><img src="FE/images/images-demo-consulting-blog-03.jpg" alt=""></a>
                                    </div>
                                    <div class="card-body p-13 md-p-11">
                                        <a href="demo-consulting-blog-single-modern.html" class="card-title mb-15px alt-font fw-600 fs-20 text-dark-gray d-inline-block">How to bring the season into your great work</a>
                                        <p>Lorem ipsum has been industry standard dummy text ever...</p>
                                        <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-16">
                                            <div class="me-auto">
                                                <span class="blog-date d-inline-block">28 August 2021</span>
                                                <div class="d-inline-block author-name">By <a href="demo-consulting-news.html" class="text-dark-gray text-decoration-line-bottom fw-600">Hugh macleod</a></div>
                                            </div>
                                            <div class="like-count fs-15 fw-600">
                                                <a href="demo-consulting-blog-single-modern.html"><i class="fa-regular fa-heart text-base-color"></i><span class="text-dark-gray align-middle">25</span></a>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- end blog item -->
                            <!-- start blog item -->
                            <li class="grid-item">
                                <div class="card border-0 border-radius-4px box-shadow-quadruple-large">
                                    <div class="blog-image">
                                        <a href="demo-consulting-blog-single-modern.html" class="d-block"><img src="FE/images/images-demo-consulting-blog-02.jpg" alt=""></a>
                                    </div>
                                    <div class="card-body p-13 md-p-11">
                                        <a href="demo-consulting-blog-single-modern.html" class="card-title mb-15px alt-font fw-600 fs-20 text-dark-gray d-inline-block">Be the strong willed one the public relationship</a>
                                        <p>Lorem ipsum has been industry standard dummy text ever...</p>
                                        <div class="author d-flex justify-content-center align-items-center position-relative overflow-hidden fs-16">
                                            <div class="me-auto">
                                                <span class="blog-date d-inline-block">26 August 2021</span>
                                                <div class="d-inline-block author-name">By <a href="demo-consulting-news.html" class="text-dark-gray text-decoration-line-bottom fw-600">Walton smith</a></div>
                                            </div>
                                            <div class="like-count fs-15 fw-600">
                                                <a href="demo-consulting-blog-single-modern.html"><i class="fa-regular fa-heart text-base-color"></i><span class="text-dark-gray align-middle">30</span></a>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!-- end blog item -->
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- end section -->
        <!-- start section -->
        <section class="pt-4 pb-4 cover-background" style="background-image:url('FE/images/demo-consulting-footer-bg.jpg');">
            <div class="opacity-extra-medium bg-gradient-black-dark-orange"></div>
            <div class="container position-relative"> 
                <div class="row align-items-center justify-content-center text-start text-sm-center text-lg-start">
                    <div class="col-xl-5 col-lg-6 col-md-7 md-mb-25px">
                        <h2 class="alt-font text-white fw-500 mb-0 cd-headline zoom fancy-text-style-4 text-shadow-double-large ls-minus-1px">Let's discuss your now 
                            <span data-fancy-text='{ "effect": "rotate", "string": ["consulting!", "business!", "innovative!"] }'></span>
                        </h2>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-8 col-sm-10 offset-xl-1 icon-with-text-style-08">
                        <div class="feature-box feature-box-left-icon-middle text-start">
                            <div class="feature-box-icon feature-box-icon-rounded w-110px h-110px xs-w-80px xs-h-80px rounded-circle bg-base-color me-20px xs-me-15px">
                                <i class="line-icon-Handshake icon-extra-large text-white lh-100"></i>
                            </div>
                            <div class="feature-box-content last-paragraph-no-margin xs-mt-15px xs-mb-15px">
                                <span class="fs-24 lh-32 xs-fs-22 xs-lh-32 text-white">Looking for collaboration? <a href="/cdn-cgi/l/email-protection#5b32353d341b22342e293f34363a323575383436" class="text-decoration-line-bottom text-white fw-500"><span class="__cf_email__" data-cfemail="6801060e072811071d1a0c0705090106460b0705">[email&nbsp;protected]</span></a></span>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
        </section>

@endsection
 