<style>
    .custom-loading-1 {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(16, 16, 16, 0.5);
    }
</style>
<div class="custom-loading-1" hidden></div>
<div class="container">
    <table id="datatable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Akhir</th>
                <th>Image</th>
                <th>Perusahaan</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lamaran as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
                {{-- <td>{{$value->tanggal_awal.' - '.$value->tanggal_akhir}}</td> --}}
                <td>{{\Carbon\Carbon::parse($value->tanggal_akhir)->format('d-m-Y')}}</td>
                <td>
                    @if($value->lamaran->perusahaan)
                    @php
                    $js = json_decode($value->lamaran->perusahaan->image)
                    @endphp
                    <a href="{{$js?'/image/loker/'.$js->url:''}}" target="_blank">
                        <img src="{{$js?'/image/loker/'.$js->url:''}}" alt="" style="" width="70px" height="30px">
                    </a>
                    @else
                    <a href="{{$value->lamaran->image?'/image/loker/'.json_decode($value->lamaran->image)->url:''}}"
                        target="_blank">
                        <img src="{{$value->lamaran->image?'/image/loker/'.json_decode($value->lamaran->image)->url:''}}"
                            alt="" style="" width="70px" height="30px">
                    </a>
                    @endif
                </td>
                <td>{{$value->lamaran->perusahaan?$value->lamaran->perusahaan->nama:$value->lamaran->nama}}</td>
                <td>{{$value->lamaran->title}}</td>
                <td>
                    <div class="row">
                        <a href="/loker/{{$value->lamaran->id}}/detail">
                            <button class="button button-mini button-border button-circle button-aqua">Detail</button>
                        </a>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <h3 class="mt-5">Daftar Lowongan Kerja</h3>
    <div class="card">
        <div class="card-body">
            <div class="">
                <table id="datatable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Akhir</th>
                            <th>Image</th>
                            <th>Perusahaan</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($loker as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
                            {{-- <td>{{$value->tanggal_awal.' - '.$value->tanggal_akhir}}</td> --}}
                            <td>{{\Carbon\Carbon::parse($value->tanggal_akhir)->format('d-m-Y')}}</td>
                            <td>
                                @if($value->perusahaan)
                                @php
                                $js = json_decode($value->perusahaan->image)
                                @endphp
                                <img src="{{$js?'/image/loker/'.$js->url:''}}" alt="" style="" width="70px"
                                    height="30px">
                                @else
                                <img src="{{$value->image?'/image/loker/'.json_decode($value->image)->url:''}}" alt=""
                                    style="" width="70px" height="30px">
                                @endif
                            </td>
                            <td>{{$value->perusahaan?$value->perusahaan->nama:$value->nama}}</td>
                            <td>{{$value->title}}</td>
                            <td>
                                <div class="row">
                                    {{-- <form id="orderForm" action="{{ '/loker/apply' }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="text" id="class_id" name="class_id" value="{{ $value->id }}"
                                            hidden>
                                    </form> --}}
                                    <button class="button button-mini button-border button-circle button-yellow"
                                        id="btnkirimloker">Kirim
                                        Lamaran</button>
                                    <a href="/loker/{{$value->id}}/detail">
                                        <button
                                            class="button button-mini button-border button-circle button-aqua">Detail</button>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    $('#btnkirimloker').on('click',function () {
        console.log('loker');
        let id = 9999;
        Swal.fire({
            background:'#0069d900',
            color: "#e1e1e1",
            width: 600,
            html:'',
            showConfirmButton: false,
            showClass: {
                popup: `
                    animated
                    fadeInUp
                    faster
                `
            },
            backdrop: `
                rgba(0,0,0,0)
                url("/GambarV2/Gif-loading-lowongan.gif")
                center
                no-repeat
            `,
        })
        setTimeout(() => {
            Swal.close();
            // $.ajax({
            //     method: 'POST',
            //     url: '/loker/apply',
            //     data: {
            //         class_id : id,
            //     },
            //     beforeSend: function() {
            //         // 
            //     },
            //     success: function(data) {
            //         console.log('success');
            //         Swal.close()
            //     },
            //     error: function(xhr) { // if error occured
            //         alert("Error occured.please try again");
            //         Swal.close()
            //     },
            //     complete: function() {
            //         console.log('complete');
            //         Swal.close()
            //     },
            // });
        }, 8000);
    })
</script>