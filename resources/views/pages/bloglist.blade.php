@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))

<section id="content">
    <div class="content-wrap">
        <div class="container clearfix">
			<h3>BLOG</h3>
			@if ($blog['data'])
				
            <div class="row gutter-40 col-mb-80">
                <div class="postcontent col-lg-9">
                    <div class="single-event">

                        @foreach ($blog['data'] as $v)
							<a href="/pages/blog/{{$v['id']}}/{{urlencode($v['title'])}}">
								<div class="card">
									<div class="card-body">
										<img src="{{$v['thumbnail']}}" alt="Thumbnail" style="width: 130px;max-height:75px;">
										&nbsp;&nbsp;&nbsp;<span style="font-size: 19px; font-weight: bold;">{{$v['title']}}</span>
										<span class="text-secondary float-right">{{Carbon\Carbon::parse($v['created_at'])->format('d-m-Y H:i:s')}}</span>
									</div>
								</div>	
							</a>
						@endforeach
						<div class="row">
							<div class="col-lg-12 text-center">
								<nav aria-label="Page navigation example">
									<ul class="pagination">
										@foreach ($blog['links'] as $p)
										<li class="page-item {{($p['active'])?'active':''}}"><a class="page-link" href="{{$p['url']}}"><?=$p['label']?></a></li>
										@endforeach
									  {{-- <li class="page-item"><a class="page-link" href="#">1</a></li>
									  <li class="page-item"><a class="page-link" href="#">2</a></li>
									  <li class="page-item"><a class="page-link" href="#">3</a></li>
									  <li class="page-item"><a class="page-link" href="#">Next</a></li> --}}
									</ul>
								  </nav>
							</div>
						</div>
                    </div>
                </div>
            </div>
			@endif

        </div>
    </div>
</section><!-- #content end -->
@include(env("CUSTOM_FOOTER","front.layout.footer"))