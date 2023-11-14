<div class="row">
    <div class="col-lg-6">
        <form action="/profile#tab-feeds" method="get">
            <label>Tanggal Pembayaran</label>
            <div class="input-group mb-4">
                <input type="date" class="form-control" value="{{ $param['date'][0] }}" placeholder="Date Start"
                    aria-label="Date Start" name="param_date_start">
                <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon5">s/d</span>
                </div>
                <input type="date" class="form-control" value="{{ $param['date'][1] }}" placeholder="Date End"
                    aria-label="Date End" name="param_date_end">
            </div>
            <div class="row">
                <div class="col-lg-8">
                    <button class="btn btn-primary btn-block" type="submit">Cari</button>
                </div>
                <div class="col-lg-4">
                    <a href="/profile#tab-feeds" class="btn btn-warning btn-block" type="button">Reset</a>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table id="datatable2" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kelas</th>
                <th>Instruktor</th>
                <th>Tanggal</th>
                <th>Rincian Kelas</th>
                <th>Unduhan</th>
                <th>Review</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($class as $key => $c)
            @foreach ($c->class as $cl)
            <tr class="text-center">
                <td width="1%">{{ $key + 1 }}</td>
                <td class="longtextoverflow" title="{{ $cl->title }}">{{ $cl->title }}</td>
                <td>
                    @foreach ($cl->instructor_list as $instructor_list)
                    <span class="badge badge-primary">{{ $instructor_list->name
                        }}</span>
                    @endforeach
                </td>
                <td><span class="badge badge-info">
                        @if(\Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')==\Carbon\Carbon::parse($cl->date_end)->format('d-m-Y'))
                        {{
                        \Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')
                        }}
                        @else
                        {{
                        \Carbon\Carbon::parse($cl->date_start)->format('d-m-Y')
                        . '-' .
                        \Carbon\Carbon::parse($cl->date_end)->format('d-m-Y') }}
                        @endif
                    </span>
                </td>
                <td>
                    <button id="evModal" class="button button-circle button-mini" data-toggle="modal"
                        data-target="#eventModal" onclick="onEvent({{ $c->event }})" title="Event">
                        Open
                    </button>
                    @if (count($c->event) > 0)
                    @foreach ($c->event as $e)
                    @if ($e->link)
                    <a href="{{ $e->link }}">
                        <button class="button button-mini button-circle">Link</button>
                    </a>
                    @endif
                    @endforeach
                    @endif
                </td>
                <td width="5%">
                    <div class="dropdown">
                        <button class="btn btn-warning dropdown-toggle btn-sm" type="button" data-toggle="dropdown"
                            aria-expanded="false" title="Opsi">
                            <i class="icon-cog"></i>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="/classes/getcertificate/{{ $c->class_id }}" target="_blank">
                                Get Certificate
                            </a>
                            <span class="dropdown-item"
                                onclick="onContent({{ $cl->content_list }})">Content/Material</span>
                        </div>
                    </div>
                </td>
                @if($cl->date_end < \Carbon\Carbon::now()->subDay())
                    <td>
                        <button class="button button-circle button-mini" @if ($c->review) onclick="onReview('{{
                            $c->review
                            }}','{{ $c->review_point }}')"
                            @else
                            onclick="review({{ $c->participant_id }})"
                            @endif>Class</button>
                        <button class="button button-circle button-mini"
                            onclick="reviewIns({{ $c->class[0]->instructor_list[0]->id }})">Intructor</button>
                    </td>
                    @else
                    <td>Kelas Belum Selesai</td>
                    @endif
            </tr>
            @endforeach
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Participant-->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/classes/review" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Review</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" id="participant_id" name="participant_id" hidden>
                    <div class="col-lg-12">
                        <label>Nilai = </label><span id="nilai_val"></span><br>
                        <input type="range" class="form-range form-control p-0" id="nilai" name="nilai"
                            value="{{ old('nilai') }}" min="1" max="5">
                        @error('nilai')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col-lg-12 bottommargin">
                        <label>Pesan</label><br>
                        <textarea name="review" id="review" cols="30" rows="10" class="form-control"></textarea>
                        @error('input2')
                        <span class="text-danger" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnReview">Save
                        changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Content-->
<div class="modal fade" id="contentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Content</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th width="1%">No</th>
                                <th>Title</th>
                                <th>Url</th>
                            </tr>
                        </thead>
                        <tbody id="tableContent">
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Event-->
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="#" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Rincian kelas</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr class="text-center">
                                <th width="1%">No</th>
                                <th>Link/Lokasi</th>
                                <th>Password</th>
                                <th>Waktu</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody id="tableEvent">
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>