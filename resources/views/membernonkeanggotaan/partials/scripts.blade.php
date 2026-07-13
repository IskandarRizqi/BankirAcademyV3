	<!-- GLOBAL SCRIPTS -->
	<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
	<script src="{{ asset('assets/js/app.js') }}"></script>
	<script src="{{ asset('assets/js/custom.js') }}"></script>
	<script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	<script>
		// Sidebar toggle (desktop collapses content, mobile slides drawer)
		const container = document.getElementById('container');
		const toggleBtn = document.getElementById('sidebarToggle');
		const overlay = document.getElementById('mobileOverlay');

		function isMobile() {
			return window.innerWidth < 992;
		}

		toggleBtn.addEventListener('click', function() {
			if (isMobile()) {
				container.classList.toggle('sidebar-open');
			} else {
				container.classList.toggle('sidebar-closed');
			}
		});

		overlay.addEventListener('click', function() {
			container.classList.remove('sidebar-open');
		});

		$(document).ready(function() {
			if (typeof App !== 'undefined') {
				App.init();
			}
		});

		function createtable(id) {
			$('#' + id).DataTable({
				"dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
					"<'table-responsive'tr>" +
					"<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0 mb-3'i><'dt--pagination'p>>",
				"oLanguage": {
					"oPaginate": {
						"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
						"sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
					},
					"sInfo": "Menampilkan halaman _PAGE_ dari _PAGES_",
					"sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
					"sSearchPlaceholder": "Pencarian",
					"sLengthMenu": "Tampilkan: _MENU_",
				},
				"stripeClasses": [],
				"lengthMenu": [10, 20, 50],
				"pageLength": 10,
			});
		}

		function numberformat(id, target) {
			new Cleave('#' + id, {
				numeral: true,
				numeralThousandsGroupStyle: 'thousand',
				noImmediatePrefix: true,
				numeralDecimalMark: ',',
				delimiter: '.',
				onValueChanged: function(e) {
					document.getElementById(target).value = e.target.rawValue;
				}
			});
		}
	</script>

	@stack('scripts')
