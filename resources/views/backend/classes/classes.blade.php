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
							<input type="date" class="form-control" value="{{$param['date_start']}}"
								placeholder="Date Start" aria-label="Date Start" name="param_date_start">
							<div class="input-group-append">
								<span class="input-group-text" id="basic-addon5">s/d</span>
							</div>
							<input type="date" class="form-control" value="{{$param['date_end']}}"
								placeholder="Date End" aria-label="Date End" name="param_date_end">
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
							<th class="text-center">
								<p>
									Jml Peserta
								</p>
								<span class="bs-tooltip text-danger" title="All">A</span>|<span
									class="bs-tooltip text-success" title="Lunas">L</span>
							</th>
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
							<td class="text-center">
								<span class="badge badge-danger" data-toggle="modal" data-target="#listPesertaModal"
									onclick="openPeserta({{$v->peserta_list['all']}})">
									{{count($v->peserta_list['all'])}}
								</span>
								|
								<span class="badge badge-success" data-toggle="modal" data-target="#listPesertaModal"
									onclick="openPeserta({{$v->peserta_list['all']}})">
									{{count($v->peserta_list['all'])}}
								</span>
							</td>
							<td>
								<button class="btn bs-tooltip {{($v->pricing)?'btn-info':'btn-dark'}}" title="Pricing"
									onclick="classPricing({{$v}})"><i class="bx bx-dollar"></i></button>
								<button class="btn bs-tooltip {{(count($v->content_list)>0)?'btn-success':'btn-dark'}}" title="File"
									onclick="classContent({{$v}})"><i class="bx bx-file"></i></button>
								<a class="btn bs-tooltip {{($v->events_exist)?'btn-primary':'btn-dark'}}" title="Event"
									href="/admin/classes/createevent/{{$v->id}}"><i class="bx bx-calendar"></i></a>
								<button class="btn bs-tooltip  {{($v->certif_exist)?'btn-warning':'btn-dark'}} dropdown-toggle" type="button"
									data-toggle="dropdown" aria-expanded="false" title="Certificate">
									<i class="bx bx-cog"></i></button>
								<div class="dropdown-menu">
									<a class="dropdown-item" title="Certificate"
										href="/admin/classes/createcertificate/{{$v->id}}">Create Certificate</a>
									<a class="dropdown-item" title="Preview"
										href="/admin/classes/previewcertificate/{{$v->id}}" target="_blank">Show
										Certificate</a>
									<a class="dropdown-item" title="Preview" href="/admin/classes/getreview/{{$v->id}}"
										target="_blank">Show
										Review</a>
								</div>
								<div class="dropdown">
								</div>
							</td>
							<td>
								<div class="dropdown">
									<button class="btn btn-warning dropdown-toggle btn-sm" type="button"
										data-toggle="dropdown" aria-expanded="false" title="Opsi">
										<i class="bx bx-cog"></i>
									</button>
									<div class="dropdown-menu">
										<a class="dropdown-item" title="Edit"
											href="/admin/classes/{{$v->id}}/edit">Edit</a>
										<a class="dropdown-item" title="Delete"
											onclick="deleteClasses({{$v->id}})">Hapus</a>
										<form action="#" method="post" id="formdelclasses">@csrf @method('DELETE')
										</form>
									</div>
								</div>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>
				<!-- Modal -->
				<div class="modal fade" id="listPesertaModal" tabindex="-1" aria-labelledby="listPesertaModalLabel"
					aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="listPesertaModalLabel">List Peserta</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div class="table-responsive">
									<table id="tblListPeserta" class="table table-bordered table-striped">
										<thead>
											<tr>
												<th>Status</th>
												<th>Nama</th>
												<th>Price</th>
											</tr>
										</thead>
										<tbody id="listPeserta">
											<tr>
												<td></td>
												<td></td>
												<td></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@include('backend.classes.newclassesmodal')
@include('backend.classes.classpricingmodal')
@include('backend.classes.classcontentmodal')
@endsection
@section('custom-js')
<script>
	createDataTable('#tblClasses');
	createDataTable('#tblListPeserta');



	$('#numClassPrice').on('input change',function () {
		var v = $(this).val();
		var n = Number(v).toLocaleString('id-ID',{
			style:'currency',
			currency:'IDR'
		});
		$('#nomClassPrice').text(n);
	});

	$('#numClassPromo').on('input change',function () {
		var v = $(this).val();
		var n = Number(v).toLocaleString('id-ID',{
			style:'currency',
			currency:'IDR'
		});
		$('#nomClassPromo').text(n);
	});

	$('.clsNumberOnPrice').on('input change',function () {
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

	function openPeserta(data){
		let = html = '';
		$('#listPeserta').html(html);
		if (data.length > 0) {
			data.forEach(el=>{
				let status = 'Belum Lunas';
				if (el.status) {
					status = 'Lunas';
				}
				let price = Number(el.price_final).toLocaleString('id-ID',{
			style:'currency',
			currency:'IDR'
		});
				html +='<tr>';
				html +='<td>'+status+'</td>';
				html += '<td>'+el.name+'</td>';
				html += '<td>'+price+'</td>';
				html +='</tr>';
			})
			$('#listPeserta').html(html);
		}
	}

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
		$('#numClassPrice').val(0);
		$('#numClassPromo').val(0);
		$('#bolClassPromo').prop('checked',false);
		$('#datPromoDateStart').val('')
		$('#datPromoDateEnd').val('')
		if (c.pricing) {
			$('#numClassPrice').val(c.pricing.price).trigger('change').trigger('input');
			$('#numClassPromo').val(c.pricing.promo_price).trigger('change').trigger('input');
			if (c.pricing.promo==1) {
				$('#bolClassPromo').prop('checked',true);
			}
			$('#datPromoDateStart').val(c.pricing.promo_start)
			$('#datPromoDateEnd').val(c.pricing.promo_end)
		}
		$('.hdnClassesId').val(c.id);
		$('.activeClassTitle').text(c.title);
		openmodal('#classPricingModal');
	}

	function classContent(c) {
		$('#tbdClassContent').html('');
		$('.hdnClassesId').val(c.id);
		if (c.content_list) {
			c.content_list.forEach(e => {
				var sd = '';
				var sg = '';
				var sv = '';
				var dd = 'style="display:none;"';
				var dg = 'style="display:none;"';
				var dv = 'style="display:none;"';

				if (e.type==1) {
					sd = 'selected';
					dd = '';
				} else if (e.type==2) {
					sg = 'selected';
					dg = '';
				} else if (e.type==3) {
					sv = 'selected';
					dv = '';
				}

				$('#tbdClassContent').append(''+
					'<tr>'+
					'	<td>'+
					'		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="'+e.id+'">'+
					'		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">'+
					'			<option value="1" '+sd+'>Dokumen</option>'+
					'			<option value="2" '+sg+'>Gambar</option>'+
					'			<option value="3" '+sv+'>Video</option>'+
					'		</select>'+
					'	</td>'+
					'	<td>'+
					'		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle" value="'+e.title+'">'+
					'	</td>'+
					'	<td>'+
					'		<small>Change File Only If Needed</small>'+
					'		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc" '+dd+' value="'+e.url+'">'+
					'		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" '+dg+' value="'+e.url+'">'+
					'		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" '+dv+' value="'+e.url+'">'+
					'	</td>'+
					'	<td>'+
					'		<button class="btn btn-danger" onclick="delClassContentRow($(this),'+e.id+')"><i class="bx bx-trash"></i></button>'+
					'	</td>'+
					'</tr>'+
				'');
			});
		}
		openmodal('#classContentModal');
	}

	function addNewClassContentRow() {
		$('#tbdClassContent').append(''+
			'<tr>'+
			'	<td>'+
			'		<input type="hidden" name="txtClassContentId[]" class="form-control txtClassContentId" value="0">'+
			'		<select name="slcClassContentType[]" class="form-control slcClassContentType" onchange="slcClassContentTypeChanged($(this))">'+
			'			<option value="1">Dokumen</option>'+
			'			<option value="2">Gambar</option>'+
			'			<option value="3">Video</option>'+
			'		</select>'+
			'	</td>'+
			'	<td>'+
			'		<input type="text" name="txtClassContentTitle[]" class="form-control txtClassContentTitle">'+
			'	</td>'+
			'	<td>'+
			'		<input type="file" name="txtClassContentDoc[]" class="form-control txtClassContentDoc">'+
			'		<input type="file" name="txtClassContentImg[]" class="form-control txtClassContentImg" style="display: none;">'+
			'		<input type="text" name="txtClassContentVid[]" class="form-control txtClassContentVid" style="display: none;">'+
			'	</td>'+
			'	<td>'+
			'		<button class="btn btn-danger" onclick="delClassContentRow($(this),0)"><i class="bx bx-trash"></i></button>'+
			'	</td>'+
			'</tr>'+
		'');
	}
	function slcClassContentTypeChanged(ths){
		ths.parent('td').parent('tr').find('.txtClassContentDoc,.txtClassContentImg,.txtClassContentVid').hide();
		var v = ths.val();
		if (v==1) {
			ths.parent('td').parent('tr').find('.txtClassContentDoc').show();
		} else if (v==2) {
			ths.parent('td').parent('tr').find('.txtClassContentImg').show();
		} else if (v==3) {
			ths.parent('td').parent('tr').find('.txtClassContentVid').show();
		}
	}
	function delClassContentRow(ths,id){
		var tr = ths.parent('td').parent('tr');
		$('.hdnContentTBDId').val($('.hdnContentTBDId').val()+','+id);
		if (!tr.attr('clsCtnId') || tr.attr('clsCtnId')==0) {
			tr.remove();
		}
	}
</script>
@endsection