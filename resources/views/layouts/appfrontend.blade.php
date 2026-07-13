<!DOCTYPE html>
<html dir="" lang="en-US">

@include('frontend.partials.head')

<body>
	@include('frontend.partials.preloader')

	<div data-aoraeditor="html">
		@include('frontend.partials.header')

		@yield('content')

		@include('frontend.partials.footer')
	</div>

	@stack('frontend-scripts')
</body>

</html>