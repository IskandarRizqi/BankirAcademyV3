@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<h3>Literasi</h3>
			@if ($blog['data'])
			<div class="row gutter-40 col-mb-80">
				@foreach ($blog['data'] as $v)
				<div class="col-lg-4 col-sm-6">
					<a href="/pages/blog/{{$v['id']}}/{{urlencode(str_ireplace( array( '\'', '/', '//', '"', ' ,' , ';'
						, '<' , '>' ), '' , $v['title']))}}">
						<div class="card shadow mb-5 bg-white" style="border-radius: 8px; min-height: 550px">
							<img src="{{$v['thumbnail']}}" width="100%" style="border-radius: 8px">
							<div class="card-body" style="padding: 0.75rem">
								<h3 class="text-capitalize mb-2">{{$v['title']}}</h3>
								{!! $v['description'] !!}
								{{-- <div class="text-center mt-2 w-100"><a
										class="btn btn-primary btn-block btn-rounded"
										style="border-radius:10px !important" href=""> Baca </a>
								</div> --}}
							</div>
						</div>
					</a>
				</div>
				@endforeach
			</div>
			<hr>
			<div class="row">
				<div class="col-lg-12 text-center">
					<nav aria-label="Page navigation blog">
						<ul class="pagination justify-content-center">
							@foreach ($blog['links'] as $k=>$p)
							<li class="page-item {{($p['active'])?'active':''}}"><a class="page-link"
									href="{{$p['url']}}">
									<?=$p['label']?>
								</a></li>
							@endforeach
						</ul>
					</nav>
				</div>
			</div>
			@endif
		</div>
	</div>
</section><!-- #content end -->
@include(env("CUSTOM_FOOTER","front.layout.footer"))