@extends('backend.template')
@section('content')
	<div class="col-lg-12">
		<div class="widget">
			<div class="widget-heading">
				<a class="btn" data-dismiss="modal" href="/admin/classes"><i class="flaticon-cancel-12"></i> Back</a>
			</div>
			<div class="widget-content">
				<form action="/admin/classes/inputcertificatetemplate/{{$class->id}}" id="newClassesCertificatetempalteForm" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
					<input type="hidden" name="hdnClassesId" value="{{$class->id}}" id="hdnClassesId">

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label>Background</label>
								<input type="file" name="filBackground" id="filBackground" class="form-control">
								<img src="{{(isset($certs->background)) ? '/'.$certs->background : '#'}}" alt="Image Preview" id="prvClassesImage" class="previewImage" style="max-width: 100%;max-height:97px;">
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label>Page Size</label>
								<?php 
									$a3 = '';
									$a4 = '';
									$letter = '';
									$legal = '';

									if (isset($certs->page_size)) {
										if ($certs->page_size=='A3') {$a3 = 'selected';}
										if ($certs->page_size=='A4') {$a4 = 'selected';}
										if ($certs->page_size=='LETTER') {$letter = 'selected';}
										if ($certs->page_size=='LEGAL') {$legal = 'selected';}
									}
								?>
								<select name="slcPageSize" class="form-control">
									<option value="A3" {{$a3}}>A3</option>
									<option value="A4" {{$a4}}>A4</option>
									<option value="LETTER" {{$letter}}>LETTER</option>
									<option value="LEGAL" {{$legal}}>LEGAL</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Date (Active s/d Expired)</label>
								<div class="input-group mb-4">
									<input type="date" class="form-control" placeholder="Date Start" aria-label="Date Start" name="datCertificateCreated" value="{{(isset($certs->certificate_created)) ? '/'.$certs->certificate_created : ''}}">
									<div class="input-group-append">
										<span class="input-group-text">s/d</span>
									</div>
									<input type="date" class="form-control" placeholder="Date End" aria-label="Date End" name="datCertificateExpired" value="{{(isset($certs->certificate_expired)) ? '/'.$certs->certificate_expired : ''}}">
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label>Content</label> &nbsp;<button type="button" class="btn btn-sm btn-info" onclick="openmodal('#classCertificateTemplateVariable')"><i class="bx bx-info-circle"></i></button>
								<textarea name="txaContent" id="txaContent">{{(isset($certs->content)) ? '/'.$certs->content : ''}}</textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-block btn-primary">Save</button>
				</form>
			</div>
		</div>

		<div class="modal fade modalwithselect2" id="classCertificateTemplateVariable" role="dialog" aria-labelledby="classCertificateTemplateVariableLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="classCertificateTemplateVariableLabel">Variabel</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal('#classCertificateTemplateVariable')">
							<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
						</button>
					</div>
					<div class="modal-body">
						<h5>PENGGUNAAN VARIABEL</h5>
						<hr>
						<span>Gunakan Variabel Berikut Untuk Mengganti Teks Secara Dinamis</span> 
						<hr>
						<table>
							<tr>
								<th>[[name]]</th>
								<td> : </td>
								<td>Participant Name</td>
							</tr>
							<tr>
								<th>[[class]]</th>
								<td> : </td>
								<td>Class Title</td>
							</tr>
							<tr>
								<th>[[date_active]]</th>
								<td> : </td>
								<td>Certificate Active Date</td>
							</tr>
							<tr>
								<th>[[date_expired]]</th>
								<td> : </td>
								<td>Certificate Expired Date</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button class="btn" data-dismiss="modal" onclick="closemodal('#classCertificateTemplateVariable')"><i class="flaticon-cancel-12"></i> Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('custom-js')
<script>
	var newClassCKEditor = CKEDITOR.replace("txaContent");
	$('#filBackground').change(function (e) { 
		getImgData(this,'#prvClassesImage');
	});
</script>
@endsection