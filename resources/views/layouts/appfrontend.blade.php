<!DOCTYPE html>
<html dir="" lang="en-US">

@include('frontend.partials.head', ['includeMarketingStyles' => true])

<body>

	<div data-aoraeditor="html">
		@include('frontend.partials.header')

		<main>
			@yield('content')
		</main>

		@include('frontend.partials.footer')
	</div>

	<script src="{{ versioned_asset('js/auto-image-compressor.js') }}"></script>
	@stack('frontend-scripts')
	@include('components.live-purchase-toast')
</body>

</html>
