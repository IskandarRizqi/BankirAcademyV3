@foreach($classes as $course)
@include('membernonkeanggotaan.components.ui.course-card', [
	'course' => $course,
	'withoutStyle' => $withoutStyle ?? false,
])
@endforeach
