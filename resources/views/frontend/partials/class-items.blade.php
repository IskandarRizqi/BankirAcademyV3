@foreach($class as $value)
@php
$realprice = $value->pricing->price ?? 0;
$afterpromo = $value->pricing->promo_price ?? 0;
$isIht = (int) data_get($value, 'iht') === 1;
$startDate = data_get($value, 'date_start');
$endDate = data_get($value, 'date_end');
$courseStatus = 'Upcoming';

if ($startDate && $endDate) {
	$start = \Carbon\Carbon::parse($startDate)->startOfDay();
	$end = \Carbon\Carbon::parse($endDate)->endOfDay();
	$today = now()->startOfDay();

	if ($today->greaterThan($end)) {
		$courseStatus = 'Completed';
	} elseif ($today->betweenIncluded($start, $end)) {
		$courseStatus = 'Running';
	}
}

$courseStatus = $isIht && $courseStatus === 'Upcoming' ? 'IHT' : $courseStatus;
@endphp
<div class="col-sm-6 col-xl-4">
	<div class="course-item">
		<a href="#">
			<div class="course-item-img lazy">
				<img src="{{ $value->image_mobile }}" alt="{{ $value->title }}">
				<span class="course-tag">
					<span>{{ $courseStatus }}</span>
				</span>
			</div>
		</a>
		<div class="course-item-info">
			<a href="#" class="title" title="{{ $value->title }}">
				{{ $value->title }}
			</a>
			<div class="d-flex align-itemes-center justify-content-between meta">
				<div class="rating">
					<svg width="16" height="15" viewBox="0 0 16 15" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M14.9922 5.21624L10.2573 4.53056L8.1344 0.242104C8.09105 0.168678 8.02784 0.10754 7.9513 0.0649862C7.87476 0.0224321 7.78764 0 7.69892 0C7.6102 0 7.52308 0.0224321 7.44654 0.0649862C7.37 0.10754 7.3068 0.168678 7.26345 0.242104L5.14222 4.52977L0.40648 5.21624C0.31946 5.22916 0.237852 5.2645 0.170564 5.31841C0.103275 5.37231 0.0528901 5.44272 0.0249085 5.52194C-0.00307309 5.60116 -0.00757644 5.68614 0.01189 5.76762C0.0313563 5.8491 0.0740445 5.92394 0.135295 5.98398L3.57501 9.33111L2.76146 14.0591C2.74696 14.1436 2.75782 14.2304 2.79281 14.3094C2.8278 14.3883 2.88549 14.4564 2.95932 14.5058C3.03314 14.5551 3.12011 14.5838 3.2103 14.5886C3.30049 14.5933 3.39026 14.5739 3.46936 14.5325L7.6985 12.3153L11.9276 14.5333C12.0068 14.5746 12.0965 14.5941 12.1867 14.5893C12.2769 14.5846 12.3639 14.5559 12.4377 14.5066C12.5115 14.4572 12.5692 14.3891 12.6042 14.3101C12.6392 14.2311 12.6501 14.1444 12.6356 14.0599L11.822 9.3319L15.2634 5.98398C15.3253 5.92392 15.3685 5.84885 15.3883 5.76699C15.4082 5.68515 15.4039 5.59969 15.3758 5.52003C15.3478 5.44036 15.2972 5.36956 15.2295 5.31541C15.1618 5.26126 15.0797 5.22586 14.9922 5.21308V5.21624Z" fill="#FFC107" />
					</svg>
					<span>0 (0 Rating)</span>
				</div>
				<div class="enrolled-student">
					<a href="#">Limit {{ $value->participant_limit }} Orang</a>
				</div>
			</div>
			<div class="course-item-info-description">
				{!! $value->content !!}
			</div>
			<div class="course-item-footer d-flex justify-content-between">
				<div class="price">
					<span class="prise_tag">
						<span class="current">Rp. {{ number_format($realprice - $afterpromo, 0, ',', ' ') }}</span>
						@if($afterpromo > 0)
						<del>Rp. {{ number_format($realprice, 0, ',', ' ') }}</del>
						@endif
					</span>
				</div>
			</div>
		</div>
	</div>
</div>
@endforeach
