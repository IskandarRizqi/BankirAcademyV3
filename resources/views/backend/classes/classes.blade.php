@extends('backend.template')
@section('content')
	<div class="col-lg-12">
		<div class="widget">
			<div class="widget-heading">
				<form action="/admin/classes">
					@csrf
					<div class="row">
						<div class="col-lg-6">
							<div class="input-group mb-4">
								<input type="date" class="form-control" value="{{$param['date_start']}}" placeholder="Date Start" aria-label="Date Start" name="param_date_start">
								<div class="input-group-append">
									<span class="input-group-text" id="basic-addon5">s/d</span>
								</div>
								<input type="date" class="form-control" value="{{$param['date_end']}}" placeholder="Date End" aria-label="Date End" name="param_date_end">
							</div>
							<div class="row">
								<div class="col-lg-8">
									<button class="btn btn-primary btn-block" type="submit">Cari</button>
								</div>
								<div class="col-lg-4">
									<a href="/admin/classes" class="btn btn-warning btn-block" type="button">Reset</a>
								</div>
							</div>
						</div>
						<div class="col-lg-6 text-right">
							<A class="btn btn-primary btn-large" type="button" href="/admin/classes/create">New</A>
						</div>
					</div>
				</form>
			</div>
			<div class="widget-content">
				<div class="table-responsive">
					<table id="tblClasses" class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Date</th>
								<th>Class</th>
								<th>Category</th>
								<th>Instructor</th>
								<th>Data</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($classes as $k=>$v)
							<tr>
								<td>
									<span hidden>
										{{Carbon\Carbon::parse($v->date_start)->format('U')}}
									</span>
									{{Carbon\Carbon::parse($v->date_start)->format('d-m-Y')}}
									s/d
									{{Carbon\Carbon::parse($v->date_end)->format('d-m-Y')}}
								</td>
								<td>{{$v->title}}</td>
								<td>{{$v->category}}</td>
								<td>
									@foreach ($v->instructor_list as $i)
									<span class="badge badge-primary">{{$i->name}}</span>
									@endforeach
								</td>
								<td>
									<button class="btn bs-tooltip btn-info" title="Pricing" onclick="classPricing({{$v}})"><i class="bx bx-dollar"></i></button>
									<button class="btn bs-tooltip btn-success" title="File"><i class="bx bx-file"></i></button>
									<button class="btn bs-tooltip btn-primary" title="Event"><i class="bx bx-calendar"></i></button>
								</td>
								<td>
									<a class="btn bs-tooltip btn-warning" title="Edit" href="/admin/classes/{{$v->id}}/edit"><i class="bx bx-edit"></i></a>
									<button class="btn bs-tooltip btn-danger" title="Delete" onclick="deleteClasses({{$v->id}})"><i class="bx bx-trash"></i></button>
									<form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')</form>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@include('backend.classes.newclassesmodal')
	@include('backend.classes.classpricingmodal')
@endsection
@section('custom-js')
<script>
	createDataTable('#tblClasses');

	$('#numClassPrice').on('input',function () {
		var v = $(this).val();
		var n = Number(v).toLocaleString('id-ID',{
			style:'currency',
			currency:'IDR'
		});
		$('#nomClassPrice').text(n);
	});

	$('#numClassPromo').on('input',function () {
		var v = $(this).val();
		var n = Number(v).toLocaleString('id-ID',{
			style:'currency',
			currency:'IDR'
		});
		$('#nomClassPromo').text(n);
	});

	$('.clsNumberOnPrice').on('input',function () {
		var n = $('#numClassPrice').val();
		var p = $('#numClassPromo').val();
		var s = $('#numClassPromoPrctg').val();
		
		var rp = (Number(n)*Number(s))/100;
		var rs = (Number(p)*100)/Number(n);
		console.log([n,p,s,rp,rs]);
		if ($(this).attr('id') == 'numClassPromo' || $(this).attr('id') == 'numClassPrice') {
			rp = p;
		}
		if ($(this).attr('id') == 'numClassPromoPrctg') {
			rs = s;
		}

		$('#numClassPromo').val(rp);
		$('#numClassPromoPrctg').val(rs);
	});

	function deleteClasses(id) {
		swal({
			title: 'Are you sure?',
			text: "You won't be able to revert this!",
			type: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Delete',
			padding: '2em'
		}).then(function(result) {
			if (result.value) {
				$('#formdelclasses').attr('action','/admin/classes/'+id);
				$('#formdelclasses').submit();
			}else{
				$('#formdelclasses').attr('action','#');
			}
		})
	}

	function classPricing(c) {
		console.log(c.pricing);
		$('#numClassPrice').val(c.pricing.price).trigger('change').trigger('input');
		$('#numClassPromo').val(c.pricing.promo_price).trigger('change').trigger('input');
		$('.hdnClassesId').val(c.id);
		$('.activeClassTitle').text(c.title);
		openmodal('#classPricingModal');
	}
</script>
@endsection