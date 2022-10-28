@extends('backend.template')
@section('content')
<div class="col-lg-12">
    <div class="widget">
        <div class="widget-heading">
            {{-- --}}
        </div>
        <div class="widget-content">
            <div class="table-responsive">
                <table id="tblReview" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Class</th>
                            <th>Review</th>
                            <th>Review Point</th>
                            <th>Review Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (isset($review))
                        @foreach ($review as $k => $r)
                        <tr>
                            <td>{{$k+1}}</td>
                            <td>@if (isset($class))
                                {{$class->title}}
                                @else
                                Tidak Ditemukan
                                @endif</td>
                            <td>{{$r->review}}</td>
                            <td>{{$r->review_point}}</td>
                            <td>{{$r->review_time}}</td>
                            <td> <a href="/admin/classes/setreview/{{$r->id}}/{{$r->review_active}}">
                                    {{$r->review_active?'Active':'De-Active'}}
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    createDataTable('#tblReview');
</script>
@endsection