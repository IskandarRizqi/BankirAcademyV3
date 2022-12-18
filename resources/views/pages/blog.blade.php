@include('front.layout.head')
@include('front.layout.topbar')
@include(env('CUSTOM_HEADER', 'front.layout.header'))
<style>
    ul {
        margin-left: 20px;
        margin-bottom: 3px;
    }

    p {
        margin-bottom: 5px;
    }
</style>
<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
            @if ($blog)
                <div class="row col-mb-50">
                    @if ($blog->thumbnail)
                        <div class="col-md-12 col-lg-12">
                            <div class="entry-image mb-0">
                                <a href="#"><img src="{{ $blog->thumbnail }}" alt="Event Single"></a>
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
                        <h3>{{ $blog->title }}</h3>
                        {!! $blog->content !!}
                    </div>
                </div>
            @endif
        </div>
    </div>
</section><!-- #content end -->
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))
