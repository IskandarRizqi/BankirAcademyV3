@extends('layouts.appfrontend')

@section('content')
<div id="content-area">
	<section id="content">
		<div class="content-wrap mt-5">
			<div class="container clearfix">
				@if ($data['data'])
				<div class="row gutter-40 col-mb-80">
					@foreach ($data['data'] as $v)
					<div class="col-lg-4 col-sm-6">
						<div class="card shadow mb-5 bg-white promo-card">
							<img class="rounded-8" src="{{ '/Image/' . $v['image'] }}" width="100%">
							<div class="card-body card-body-compact">
								<h3 class="text-capitalize m-0">{{$v['nama']}}</h3>
								{{$v['description']}}
								@if ($v['kode'])
								@endif
                                <span class="btn mt-4 promo-info">
									<div class="row align-items-center">
										<div class="col text-left ml-2">
											<small class="fs-2">Kode Promo</small>
											<h4 class="promo-title">
												{{ $v['kode']?$v['kode']:'-' }}
											</h4>
										</div>
										<div class="col">
											<span class="btn btn-outline-primary btn-sm float-right rounded-8"
											>Copy</span>
										</div>
									</div>
								</span>
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
								@foreach ($data['links'] as $k => $p)
								<li class="page-item {{ $p['active'] ? 'active' : '' }}"><a class="page-link"
										href="{{ $p['url'] }}">
										<?= $p['label'] ?>
									</a></li>
								@endforeach
							</ul>
						</nav>
					</div>
				</div>
				@endif
				<img src="{{asset('a_Cara_pakai_promo.jpg')}}" alt="">
			</div>
		</div>
	</section>
</div>
@endsection
