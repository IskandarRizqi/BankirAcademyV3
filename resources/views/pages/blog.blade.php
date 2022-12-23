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
            <div class="row col-mb-50">
                @if ($class)
                @if ($class->thumbnail)
                <div class="col-md-12 col-lg-12">
                    <div class="entry-image mb-0">
                        <a href="#"><img src="{{ $class->thumbnail }}" alt="Event Single"></a>
                        {{-- <div class="entry-overlay d-flex align-items-center justify-content-center">
                            <span class="d-none d-md-flex">Starts in: </span>
                            <div class="countdown d-block d-md-flex" data-year="2020" data-month="12"></div>
                        </div> --}}
                    </div>
                </div>
                @endif
                <div class="col-md-9 col-lg-9">
                    <h3>{{ $class->title }}</h3>
                    {!! $class->content !!}
                </div>
                <div class="sidebar col-md-3 col-lg-3">
                    <div class="sidebar-widgets-wrap">
                        <div class="widget clearfix">
                            <h4>Literasi</h4>
                            <div class="posts-sm row col-mb-30" id="post-list-sidebar">
                                @foreach ($literasi as $p)
                                <a href="#">
                                    <div class="entry col-12">
                                        <div class="grid-inner row no-gutters">
                                            <div class="col mr-2 d-flex align-items-center">
                                                <img src="{{$p->thumbnail}}" alt="Image" height="auto" width="100%">
                                            </div>
                                            <div class="col">
                                                <div class="entry-title">
                                                    <h4>{{substr($p->title,0,47)}}@if (strlen($p->title) > 47)...@endif
                                                    </h4>
                                                </div>
                                                <div class="entry-meta">
                                                    <ul>
                                                        <li class="text-truncate" style="max-width: 200px">
                                                            {{$p->description}}</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section><!-- #content end -->
@include(env('CUSTOM_FOOTER', 'front.layout.footer'))