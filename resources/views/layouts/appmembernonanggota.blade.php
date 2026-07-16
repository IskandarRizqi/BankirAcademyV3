<!DOCTYPE html>
<html lang="en">

@include('membernonkeanggotaan.partials.head')

<body>
	<div class="main-container" id="container">
		<div class="mobile-overlay" id="mobileOverlay"></div>

		@include('membernonkeanggotaan.partials.sidebar')
		@include('membernonkeanggotaan.partials.topbar')

		<div class="main-content">
			<div class="content-body">
				@yield('content')
			</div>

			@include('membernonkeanggotaan.partials.footer')
		</div>
	</div>

	@include('membernonkeanggotaan.partials.scripts')
</body>

</html>
