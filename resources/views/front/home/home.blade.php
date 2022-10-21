@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")

<!-- Content -->
<section id="slider" class="slider-element h-auto" style="background-color: #222;">
    <div class="slider-inner">
        <div class="owl-carousel carousel-widget" data-margin="0" data-items="1" data-pagi="false" data-loop="true"
            data-animate="fadeIn" data-speed="450" data-autoplay="5000">
            <a href="#"><img src="" alt="Slider"></a>
        </div>
    </div>
</section>
<style>
    .scroll-no-ui {
        height: 100%;
        width: 100%;
        border: 1px solid green;
        overflow: hidden;
    }

    .scroll-ui {
        width: 100%;
        height: 99%;
        border: 1px solid blue;
        overflow: auto;
        padding-right: 15px;
    }
</style>
<section id="content">
    <div class="content-wrap" style="padding: 0px;">
        <div class="section border-top-0 m-0">
            <div class="container">
                <div class="heading-block center">
                    <h2>KELAS POPULER</h2>
                    <!-- <span>Sub-Title for the Heading Block</span> -->
                </div>
                <div class="row" id="sld">
                    @foreach ($pop as $p)
                    <div class="col m-3">
                        <div style="height:190px;border-radius: 25px; box-shadow: 5px 10px 19px #e9e9e9;background-color:white; overflow: hidden;"
                            class="row">
                            <div class="col-4"
                                style="background-image:url('<?= $p->image ?>');background-position:center;background-size:cover;border-radius: 25px 0 0 25px;">
                            </div>
                            <div class="col-8 p-3 "
                                style="word-wrap: break-word;overflow: hidden;text-overflow: ellipsis;max-height:190px; overflow: auto">
                                <h5 class="text-uppercase">{{$p->title}}</h5>
                                {{-- <p href="#"><i class="icon-time"></i> 11:00 - 19:00</p> --}}
                                {{-- <span style="position: absolute; left: 13px; bottom: 13px; background:white;">
                                </span> --}}
                                <div class="row" style="height: 60px; ">
                                    <div class="col-8">
                                        <p style="margin-bottom: 0px;">
                                            {{$p->instructor_list[0]->name}}</p>
                                        <p style="margin-bottom: 0px;">
                                            {{$p->instructor_list[0]->title}}</p>
                                    </div>
                                    <div class="col-4">
                                        <img class="rounded" width="50px" height="50px"
                                            src="Image/{{json_decode($p->instructor_list[0]->picture)->url}}" alt="">
                                    </div>
                                </div>
                                <button class="btn btn-secondary btn-block mt-4 btn-sm" width='100%'>Detail</button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
        </div>
        <div class="section border-top-0 m-0">
            <div class="container text-center">

                <div class="heading-block center">
                    <h2>KELAS BEST SELLER</h2>
                    <!-- <span>Sub-Title for the Heading Block</span> -->
                </div>
                <div class="row" id="sld1">
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="section border-top-0 m-0">
            <div class="container text-center">

                <div class="heading-block center">
                    <h2>KELAS TERBARU</h2>
                    <!-- <span>Sub-Title for the Heading Block</span> -->
                </div>
                <div class="row" id="sld2">
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="entry event col-4">
                        <div class="grid-inner row align-items-center no-gutters p-4">
                            <div class="entry-image col-md-4 mb-md-0">
                                <a href="#">
                                    <img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Inventore voluptates velit totam ipsa tenetur">
                                    <div class="entry-date">10<span>Apr</span></div>
                                </a>
                            </div>
                            <div class="col-md-8 pl-md-4">
                                <div class="entry-title title-xs">
                                    <h2><a href="#">Inventore voluptates velit totam ipsa tenetur</a></h2>
                                </div>
                                <div class="entry-meta">
                                    <ul>
                                        <li><a href="#"><i class="icon-time"></i> 11:00 - 19:00</a></li>
                                        <li><a href="#"><i class="icon-map-marker2"></i> Melbourne, Australia</a></li>
                                    </ul>
                                </div>
                                <div class="entry-content">
                                    <a href="#" class="btn btn-secondary" disabled="disabled">Buy Tickets</a> <a
                                        href="#" class="btn btn-danger">Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="section border-top-0 m-0">
            <div class="container text-center">

                <div class="heading-block center">
                    <h2>SEMUA KELAS</h2>
                    <!-- <span>Sub-Title for the Heading Block</span> -->
                </div>

                <div class="post-grid row grid-container gutter-30" id="sldall">

                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                    <div class="entry col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="grid-inner">
                            <div class="entry-image">
                                <a href="#"><img src="{{asset('front/images/thumbs/1.jpg')}}"
                                        alt="Standard Post with Image"></a>
                            </div>
                            <div class="entry-title">
                                <h2><a href="blog-single.html">This is a Standard post with a Preview Image</a></h2>
                            </div>
                            <div class="entry-meta">
                                <ul>
                                    <li><i class="icon-calendar3"></i> 10th Feb 2021</li>
                                    <li><a href="blog-single.html#comments"><i class="icon-comments"></i> 13</a></li>
                                    <li><a href="#"><i class="icon-camera-retro"></i></a></li>
                                </ul>
                            </div>
                            <!-- <div class="entry-content">
                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ratione, voluptatem, dolorem animi nisi autem blanditiis enim culpa reiciendis et explicabo tenetur!</p>
                                <a href="blog-single.html" class="more-link">Read More</a>
                            </div> -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- #content end -->

@include("front.layout.footer")
<script>
    $(document).ready(function() {
        $('#sldall').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld1').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
        $('#sld2').slick({
            dots: true,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });

    })
</script>