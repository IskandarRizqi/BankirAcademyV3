<div class="modal fade" id="newClassesModal" tabindex="-1" role="dialog" aria-labelledby="newClassesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newClassesModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal('#newClassesModal')">
					<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
				<form action="/admin/classes" id="newClassesForm" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
					<input type="hidden" name="hdnClassesId" value="0" id="hdnClassesId">

					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="txtClassesTitle">Title</label>
								<input type="text" name="txtClassesTitle" id="txtClassesTitle" class="form-control" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="slcClassesCategory">Category</label>
								<select class="form-control tagging mdlslc2tag" name="slcClassesCategory" name="slcClassesCategory" required>
									<option value=""></option>
									@foreach ($category as $ctg)
										<option value="{{$ctg}}">{{$ctg}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="datClassesDateStart">Date Start</label>
								<div class="input-group mb-4">
									<input type="date" class="form-control" name="datClassesDateStart" id="datClassesDateStart" placeholder="Date Start" aria-label="Date Start" required>
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon5">s/d</span>
									</div>
									<input type="date" class="form-control" name="datClassesDateEnd" id="datClassesDateEnd" placeholder="Date End" aria-label="Date End" required>
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="txtClassesInstructor">Instruktor</label>
								<select class="form-control mdlslc2" multiple name="txtClassesInstructor[]" required>
									@foreach ($instructor as $ins)
										<option value="{{($ins->id)}}">{{$ins->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="slcClassesTags">Tag</label>
								<select class="form-control tagging mdlslc2tag" multiple name="slcClassesTags[]" name="slcClassesTags" required>
									{{-- @foreach ($category as $ctg)
										<option value="{{$ctg}}">{{$ctg}}</option>
									@endforeach --}}
								</select>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="filClassesImage">Image</label>
								<input type="file" name="filClassesImage" id="filClassesImage" class="form-control" required>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="numClassesLimit">Participant Limit</label>
								<input type="number" min="1" max="999" value="13" name="numClassesLimit" id="numClassesLimit" class="form-control" required>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="form-group">
								<label for="txaClassesContent">Description</label>
								<textarea name="txaClassesContent" id="txaClassesContent" class="form-control" required></textarea>
							</div>
						</div>
					</div>
				</form>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" onclick="closemodal('#newClassesModal')"><i class="flaticon-cancel-12"></i> Discard</button>
                <button type="button" class="btn btn-primary" onclick="$('#newClassesForm').submit()">Save</button>
            </div>
        </div>
    </div>
</div>