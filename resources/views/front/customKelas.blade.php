@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))

<div class="container clearfix">
    <section id="content">
        <div class="content-wrap">
            @if ($data)
            <div class="row gutter-40 col-mb-80" {{$data->type==7?'hidden':''}}>
                <div class="row col-mb-50">
                    @if ($data->thumbnail)
                    <div class="col-md-12 col-lg-12">
                        <div class="postcontent col-lg-9">
                            <div class="single-event">
                                <div class="entry-image mb-0">
                                    <a href="#"><img src="{{$data->thumbnail}}" alt="Event Single"></a>
                                    {{-- <div class="entry-overlay d-flex align-items-center justify-content-center">
                                        <span class="d-none d-md-flex">Starts in: </span>
                                        <div class="countdown d-block d-md-flex" data-year="2020" data-month="12"></div>
                                    </div> --}}
                                </div>
                            </div>
                            @endif

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

                            <div class="col-md-10 col-lg-12">
                                <h3>{{$data->title}}</h3>
                                {!!$data->content!!}
                            </div>
                            <div class="w-100"></div>
                            <div class="w-100"></div>
                            <a href="/registerinstructor" class="btn btn-success btn-rounded"
                                style="border-radius:10px !important">Setuju</a>
                            <a href="/" class="btn btn-secondary btn-rounded"
                                style="border-radius:10px !important">Batal</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row gutter-40 col-mb-80" {{$data->type==7?'':'hidden'}}>
                <div class="col-md-12 col-lg-12">
                    <div class="postcontent col-lg-12">
                        <div class="single-event">
                            <div class="entry-image mb-4">
                                <h3>{{$data->title}}</h3>
                                <a href="#"><img src="{{$data->thumbnail}}" alt="Event Single"></a>
                                {{-- <div class="entry-overlay d-flex align-items-center justify-content-center">
                                    <span class="d-none d-md-flex">Starts in: </span>
                                    <div class="countdown d-block d-md-flex" data-year="2020" data-month="12"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        @isset($data->content)
                        @for ($i=0; $i < count(json_decode($data->content)[0]); $i++)
                            <div class="toggle toggle-border">
                                <div class="toggle-header">
                                    <div class="toggle-icon">
                                        <i class="toggle-closed icon-line-plus"></i>
                                        <i class="toggle-open icon-line-minus"></i>
                                    </div>
                                    <div class="toggle-title">
                                        {{json_decode($data->content)[0][$i]}}
                                    </div>
                                </div>
                                <div class="toggle-content ml-4" style="display: none;">
                                    {!!json_decode($data->content)[1][$i]!!}</div>
                            </div>
                            @endfor
                            @endisset
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section><!-- #content end -->
</div>
@include(env("CUSTOM_FOOTER","front.layout.footer"))