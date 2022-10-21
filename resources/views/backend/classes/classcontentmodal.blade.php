<div class="modal fade modalwithselect2" id="classContentModal" role="dialog" aria-labelledby="classContentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="classContentModalLabel">Content</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closemodal('#classContentModal')">
					<svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>
            <div class="modal-body">
				<h5 class="activeClassTitle">CLASS NAME GOES HERE</h5>
				<form action="/admin/classes/setcontent" id="newClassesForm" method="POST" enctype="multipart/form-data">
					@csrf
					<input type="hidden" name="_method" value="POST" id="hdnClassesMethod">
					<input type="hidden" name="hdnClassesId" value="0" class="hdnClassesId">

					<div class="table-responsive">
						<table class="table">
							<thead>
								<tr>
									<th>Type</th>
									<th>Title</th>
									<th>URL/Upload</th>
									<th>Delete</th>
								</tr>
							</thead>
							<tbody id="tbdClassContent">
								
							</tbody>
						</table>
					</div>
					<div class="col-lg-12">
						<button type="button" class="btn btn-block btn-primary" onclick="addNewClassContentRow()">+</button>
					</div>
					<hr>
					<button class="btn" data-dismiss="modal" onclick="closemodal('#classContentModal')"><i class="flaticon-cancel-12"></i> Discard</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</form>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>