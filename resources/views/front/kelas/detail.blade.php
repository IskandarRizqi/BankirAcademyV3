@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))

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



                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <h4>Kelas Timeline</h4>

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="datatable1" cellspacing="0" width="100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Waktu</th>
                                                <th>Deskripsi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($event as $e => $val)
                                            <tr class="text-center">
                                                <td width="1%">{{$e + 1}}</td>
                                                <td width="20%">
                                                    <span class="badge badge-danger">{{$val->time_start.'-'.$val->time_end}}</span>
                                                </td>
                                                <!-- <td class="longtextoverflow">{{$val->description}}</td> -->
                                                <td>
                                                    <button class="button button-circle button-small" onclick="infodesk({{$val}})">Lihat Deskripsi</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-12" style="padding-bottom: 0px;">
                                <form id="orderForm" action="{{'/order'}}" method="POST">
                                    @csrf
                                    <input type="text" id="class_id" name="class_id" value="{{$class->id}}" hidden>
                                    @auth
                                    <button class="button button-circle btn-block text-center">Order sekarang</button>
                                    @else
                                    <span class="button button-circle btn-block text-center" data-toggle="modal" data-target="#modelId" data-backdrop="static" data-keyboard="false">Order sekarang</span>
                                    @endauth
                                    <button class="button button-circle btn-block text-center" hidden>Order sekarang</button>
                                </form>
                            </div>
                            <script>
                                // $('#orderForm').submit()
                            </script>
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
                                                <a href="class/{{$p->unique_id}}/{{urlencode(str_ireplace( array( '\'', '/', '//', '"', ',' , ';', '<', '>' ), '', $p->title))}}"><img src="{{$p->image}}" alt="Image"></a>
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
@include(env("CUSTOM_FOOTER","front.layout.footer"))

<script>
    $(document).ready(function() {})

    function infodesk(desk) {
        console.log(desk)
        Swal.fire({
            title: 'Deskripsi kelas',
            width: 900,
            padding: '2em',
            text: desk.description,
        })
    }
</script>