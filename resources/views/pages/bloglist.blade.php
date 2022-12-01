@include("front.layout.head")
@include("front.layout.topbar")
@include(env("CUSTOM_HEADER","front.layout.header"))

<section id="content">
	<div class="content-wrap">
		<div class="container clearfix">
			<h3>BLOG</h3>
			@if ($blog['data'])
			<div class="row gutter-40 col-mb-80">
				<div class="postcontent col-lg-12">
					<div class="single-event">
						<div class="row">
							@foreach ($blog['data'] as $v)
							<div class="col-lg-3 col-sm-6 mb-4">
								<div class="card">
									<div class="card-body">
										<div class="card" style="min-height: 0px !important"> <img
												src="{{$v['thumbnail']}}" width="100%"> </div>
										<h5 class="text-uppercase mt-2" style="margin-bottom: 0px !important">
											{{$v['title']}}</h5>
										<div class="text-center mt-2 w-100"><a
												class="btn btn-primary btn-block btn-rounded"
												style="border-radius:10px !important"
												href="/pages/blog/{{$v['id']}}/{{urlencode(str_ireplace( array( '\'', '/', '//', '"', '
												,' , ';' , '<' , '>' ), '' , $v['title']))}}"> Detail </a>
										</div>
									</div>
								</div>
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
					</div>
				</div>
			</div>
			@endif

		</div>
	</div>
</section><!-- #content end -->
@include(env("CUSTOM_FOOTER","front.layout.footer"))