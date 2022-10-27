@include("front.layout.head")
@include("front.layout.topbar")
@include("front.layout.header")

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">

            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="single-event">

                        <div class="row col-mb-50">
                            <div class="col-md-12 col-lg-12">
                                <div class="entry-image mb-0">
                                    <a href="#"><img src="{{$class->image}}" alt="Event Single"></a>
                                    {{-- <div class="entry-overlay d-flex align-items-center justify-content-center">
                                        <span class="d-none d-md-flex">Starts in: </span>
                                        <div class="countdown d-block d-md-flex" data-year="2020" data-month="12"></div>
                                    </div> --}}
                                </div>
                            </div>

                            {{-- <div class="col-md-5 col-lg-4">
                                <div class="card event-meta mb-3">
                                    <div class="card-header">
                                        <h5 class="mb-0">Kelas Info:</h5>
                                    </div>
                                    <div class="card-body">
                                        <ul class="iconlist mb-0">
                                            <li><i class="icon-calendar3"></i> 31st March, 2021</li>
                                            <li><i class="icon-time"></i> 20:00 - 02:00</li>
                                            <li><i class="icon-map-marker2"></i> Ibiza, Spain</li>
                                            <li><i class="icon-euro"></i> <strong>99.99</strong></li>
                                        </ul>
                                    </div>
                                </div>
                                <a href="#" class="btn btn-success btn-block btn-lg">Buy Tickets</a>
                            </div> --}}

                            <div class="w-100"></div>

                            <div class="col-md-10 col-lg-12">
                                <h3>{{$class->title}}</h3>
                                {!!$class->content!!}
                            </div>



                            <div class="w-100"></div>



                            <div class="col-md-12">
                                <h4>Kelas Timeline</h4>

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Timings</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event as $e)
                                            <tr>
                                                <td><span
                                                        class="badge badge-danger">{{$e->time_start.'-'.$e->time_end}}</span>
                                                </td>
                                                <td>{{$e->description}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <form action="{{'/order'}}" method="POST">
                                    @csrf
                                    <input type="text" name="class_id" value="{{$class->id}}" hidden>
                                    <button class="btn btn-primary btn-block">Order</button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="sidebar col-lg-3">
                    <div class="sidebar-widgets-wrap">

                        <div class="widget clearfix">

                            <h4>Upcoming Kelas</h4>
                            <div class="posts-sm row col-mb-30" id="post-list-sidebar">
                                @foreach ($pop as $p)
                                <div class="entry col-12">
                                    <div class="grid-inner row no-gutters">
                                        <div class="col-auto">
                                            <div class="entry-image">
                                                <a href="class/{{$p->unique_id}}/{{$p->title}}"><img src="{{$p->image}}"
                                                        alt="Image"></a>
                                            </div>
                                        </div>
                                        <div class="col pl-3">
                                            <div class="entry-title">
                                                <h4><a href="#">{{$p->title}}</a></h4>
                                            </div>
                                            <div class="entry-meta">
                                                <ul>
                                                    <li>{{$p->date_start}}</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                        </div>

                        <div class="widget clearfix">

                            <h4>Kelas</h4>
                            <div id="oc-portfolio-sidebar" class="owl-carousel carousel-widget" data-items="1"
                                data-margin="10" data-loop="true" data-nav="false" data-autoplay="5000">

                                <div class="portfolio-item">
                                    <div class="portfolio-image">
                                        <a href="#">
                                            <img src="{{asset('front/images/thumbs/1.jpg')}}" alt="Image">
                                        </a>
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content dark" data-hover-animate="fadeIn"
                                                data-hover-speed="350">
                                                <a href="https://vimeo.com/89396394"
                                                    class="overlay-trigger-icon bg-light text-dark"
                                                    data-hover-animate="zoomIn" data-hover-speed="350"
                                                    data-lightbox="iframe"><i class="icon-line-play"></i></a>
                                            </div>
                                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"
                                                data-hover-speed="350"></div>
                                        </div>
                                    </div>
                                    <div class="portfolio-desc center pb-0">
                                        <h3><a href="portfolio-single-video.html">Inventore voluptates velit totam ipsa
                                                tenetur</a></h3>
                                        <span><a href="#">Melbourne, Australia</a></span>
                                    </div>
                                </div>

                                <div class="portfolio-item">
                                    <div class="portfolio-image">
                                        <a href="portfolio-single.html">
                                            <img src="{{asset('front/images/thumbs/1.jpg')}}" alt="Image">
                                        </a>
                                        <div class="bg-overlay">
                                            <div class="bg-overlay-content dark" data-hover-animate="fadeIn"
                                                data-hover-speed="350">
                                                <a href="images/blog/full/1.jpg"
                                                    class="overlay-trigger-icon bg-light text-dark"
                                                    data-hover-animate="zoomIn" data-hover-speed="350"
                                                    data-lightbox="image"><i class="icon-line-plus"></i></a>
                                            </div>
                                            <div class="bg-overlay-bg dark" data-hover-animate="fadeIn"
                                                data-hover-speed="350"></div>
                                        </div>
                                    </div>
                                    <div class="portfolio-desc center pb-0">
                                        <h3><a href="portfolio-single.html">Nisi officia adipisci molestiae aliquam</a>
                                        </h3>
                                        <span><a href="#">Perth, Australia</a></span>
                                    </div>
                                </div>

                            </div>


                        </div>

                        {{-- <div class="widget clearfix">

                            <h4>Recent Kelas in Video</h4>
                            <iframe src="//player.vimeo.com/video/103927232" width="500" height="250"
                                allow="autoplay; fullscreen" allowfullscreen></iframe>

                        </div> --}}


                    </div>
                </div>
            </div>

        </div>
    </div>
</section><!-- #content end -->
@include("front.layout.footer")