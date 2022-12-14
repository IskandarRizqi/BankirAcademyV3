@include('front.layout.head')

<section id="content">
    <div class="content-wrap" style="padding: 0px !important">
        <img class="d-none d-lg-block" src="{{ asset('bgdesktop.webp') }}" alt="">
        <img class="d-block d-md-none" src="{{ asset('bgmobile3.webp') }}" alt="">
    </div>
</section><!-- #content end -->
{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
