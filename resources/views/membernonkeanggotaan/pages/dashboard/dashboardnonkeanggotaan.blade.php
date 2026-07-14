@extends('layouts.appmembernonanggota')
@section('content')
<style>
	.dashboard-card {
		background: #ffffff;
		border: 1px solid #e5e7eb;
		border-radius: 10px;
		box-shadow: 0 1px 2px rgba(15, 23, 42, 0.04);
	}

	.dashboard-card-column {
		display: flex;
	}

	.member-dashboard-grid {
		row-gap: 24px;
	}
</style>

<div class="row member-dashboard-grid" id="cancel-row">
	<div class="col-lg-6 col-12 layout-top-spacing layout-spacing dashboard-card-column">
		@include('membernonkeanggotaan.components.ui.learning-overview', ['overview' => $learningOverview ?? []])
	</div>
	<div class="col-lg-6 col-12 layout-top-spacing layout-spacing dashboard-card-column">
		@include('membernonkeanggotaan.components.ui.membership-status')
	</div>
	<div class="col-lg-8 col-12 layout-top-spacing layout-spacing dashboard-card-column">
		@include('membernonkeanggotaan.components.ui.learning-class-chart', ['chart' => $learningChart ?? []])
	</div>
	<div class="col-lg-4 col-12 layout-top-spacing layout-spacing dashboard-card-column">
		@include('membernonkeanggotaan.components.ui.strength-weakness-analysis')
	</div>
</div>
@endsection
