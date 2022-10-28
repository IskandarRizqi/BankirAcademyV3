<!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
<script src="{{ asset('Backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('Backend/assets/js/app.js') }}"></script>
<script>
	$(document).ready(function() {
		App.init();
	});
</script>
<script src="{{ asset('Backend/assets/js/custom.js') }}"></script>
<!-- END GLOBAL MANDATORY SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
<script src="{{asset('Backend/plugins/apex/apexcharts.min.js')}}"></script>
<script src="{{asset('Backend/assets/js/dashboard/dash_1.js')}}"></script>
<script src="{{asset('Backend/plugins/table/datatable/datatables.js')}}"></script>
<script src="{{asset('Backend/assets/js/scrollspyNav.js')}}"></script>
<script src="{{asset('Backend/plugins/select2/select2.min.js')}}"></script>
<script src="{{asset('Backend/plugins/select2/custom-select2.js')}}"></script>
<script src="{{asset('Backend/assets/js/elements/tooltip.js')}}"></script>
<script src="{{asset('Backend/plugins/file-upload/file-upload-with-preview.min.js')}}"></script>
<script src="{{asset('Backend/plugins/ckeditor/ckeditor.js')}}"></script>
<script src="{{asset('Backend/plugins/sweetalerts/sweetalert2.min.js')}}"></script>
<script src="{{asset('Backend/plugins/sweetalerts/custom-sweetalert.js')}}"></script>
<script>
	$(document).ready(function() {
		$('.slc2').select2({

		});
		$('.slc2tag').select2({
			tags: true,
		});
		$('a').attr('data-active', 'false');
		$('a').attr('aria-expanded', 'false');
		//get path now
		var pathNow = window.location.pathname;
		//activate menu based on path
		$('a[href="' + pathNow + '"]').attr('data-active', 'true');
		$('a[href="' + pathNow + '"]').attr('aria-expanded', 'true');
		$('a[href="' + pathNow + '"]').parent('li').parent('ul').siblings('.dropdown-toggle').attr('data-active', 'true');
		$('a[href="' + pathNow + '"]').parent('li').parent('ul').siblings('.dropdown-toggle').attr('aria-expanded', 'true');
		$('a[href="' + pathNow + '"]').parent('li').parent('ul').addClass('show');
	});

	function createDataTable(elm, obj = {}) {
		$(elm).DataTable({
			...obj,
			"dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
				"<'table-responsive'tr>" +
				"<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
			"oLanguage": {
				"oPaginate": {
					"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
					"sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
				},
				"sInfo": "Showing page _PAGE_ of _PAGES_",
				"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
				"sSearchPlaceholder": "Search...",
				"sLengthMenu": "Results :  _MENU_",
			},
		});
	}

	function openmodal(elm) {
		$(elm).modal('show');
	}

	function closemodal(elm) {
		$(elm).modal('hide');
	}

	function getImgData(fil, prv) {
		const files = fil.files[0];
		if (files) {
			const fileReader = new FileReader();
			fileReader.readAsDataURL(files);
			fileReader.addEventListener("load", function() {
				$(prv).attr('src', this.result);
			});
		}
	}

	// function globalgetactivemenu() {
	// 	//deactivate menu

	// }
</script>
<!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->