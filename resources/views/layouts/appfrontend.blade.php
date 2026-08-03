<!DOCTYPE html>
<html dir="" lang="en-US">

@include('frontend.partials.head')

<body>

	<div data-aoraeditor="html">
		@include('frontend.partials.header')

		<main>
			@yield('content')
		</main>

		@include('frontend.partials.footer')
	</div>

	@stack('frontend-scripts')
	@include('components.live-purchase-toast')
</body>

</html>
