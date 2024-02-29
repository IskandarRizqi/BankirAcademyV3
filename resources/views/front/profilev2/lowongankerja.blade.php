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
    @foreach($lamaran as $key => $value)
    <div class="card mb-2" style="border-radius: 10px">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    @if($value->lamaran->perusahaan)
                    @php
                    $js = json_decode($value->lamaran->perusahaan->image)
                    @endphp
                    <a href="{{$js?'/image/loker/'.$js->url:''}}" target="_blank">
                        <img src="{{$js?'/image/loker/'.$js->url:''}}" alt="" style="">
                    </a>
                    @else
                    <a href="{{$value->lamaran->image?'/image/loker/'.json_decode($value->lamaran->image)->url:''}}"
                        target="_blank">
                        <img src="{{$value->lamaran->image?'/image/loker/'.json_decode($value->lamaran->image)->url:''}}"
                            alt="" style="">
                    </a>
                    @endif
                </div>
                <div class="col-md-5">
                    <p class="m-0">
                        <strong>{{$value->lamaran->perusahaan?$value->lamaran->perusahaan->nama:$value->lamaran->nama}}</strong>
                    </p>
                    <p class="">
                        {{$value->lamaran->title}}
                    </p>
                    <div class="mt-2">
                        <svg width="16" height="21" viewBox="0 0 16 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M7.99995 11.6365C7.28074 11.6365 6.57769 11.4232 5.97969 11.0237C5.3817 10.6241 4.91562 10.0562 4.64039 9.39171C4.36516 8.72725 4.29315 7.9961 4.43346 7.29071C4.57377 6.58533 4.9201 5.93739 5.42865 5.42884C5.93721 4.92028 6.58515 4.57395 7.29053 4.43364C7.99591 4.29333 8.72707 4.36535 9.39152 4.64057C10.056 4.9158 10.6239 5.38188 11.0235 5.97988C11.423 6.57787 11.6363 7.28093 11.6363 8.00013C11.6352 8.9642 11.2517 9.88845 10.57 10.5702C9.88827 11.2519 8.96402 11.6353 7.99995 11.6365ZM7.99995 5.81832C7.56843 5.81832 7.14659 5.94628 6.7878 6.18602C6.429 6.42576 6.14935 6.76651 5.98421 7.16519C5.81908 7.56386 5.77587 8.00255 5.86006 8.42578C5.94424 8.84901 6.15204 9.23778 6.45717 9.54291C6.7623 9.84804 7.15107 10.0558 7.5743 10.14C7.99753 10.2242 8.43622 10.181 8.83489 10.0159C9.23357 9.85073 9.57432 9.57108 9.81406 9.21228C10.0538 8.85349 10.1818 8.43165 10.1818 8.00013C10.1812 7.42166 9.95113 6.86704 9.54209 6.45799C9.13304 6.04895 8.57842 5.81889 7.99995 5.81832Z"
                                fill="#979797" />
                            <path
                                d="M8 20.3636L1.86473 13.128C1.77948 13.0193 1.69512 12.91 1.61164 12.8C0.56363 11.4195 -0.00253177 9.73324 8.51118e-06 7.99999C8.51118e-06 5.87826 0.842863 3.84343 2.34315 2.34314C3.84344 0.842854 5.87827 0 8 0C10.1217 0 12.1566 0.842854 13.6568 2.34314C15.1571 3.84343 16 5.87826 16 7.99999C16.0025 9.73246 15.4366 11.4179 14.3891 12.7978L14.3884 12.8C14.3884 12.8 14.1702 13.0865 14.1374 13.1251L8 20.3636ZM2.7731 11.9236C2.7731 11.9236 2.94255 12.1476 2.9811 12.1956L8 18.1149L13.0254 12.1876C13.0574 12.1476 13.2284 11.9214 13.2284 11.9214C14.0845 10.7935 14.5471 9.41601 14.5454 7.99999C14.5454 6.26403 13.8558 4.59917 12.6283 3.37166C11.4008 2.14415 9.73596 1.45454 8 1.45454C6.26404 1.45454 4.59918 2.14415 3.37167 3.37166C2.14416 4.59917 1.45455 6.26403 1.45455 7.99999C1.45303 9.41689 1.91621 10.7952 2.7731 11.9236Z"
                                fill="#979797" />
                        </svg>
                        {{$value->lamaran->alamat}}
                    </div>
                </div>
                <div class="col-md-5 text-right">
                    <p class="m-0">
                        <strong>{{$value->tanggal_date}}</strong>
                    </p>
                    <span class="badge badge-info text-white"><svg width="14" height="14" viewBox="0 0 14 14"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.88173 9.74554L3.18164 7.04482L4.08146 6.145L5.88173 7.94464L9.481 4.34473L10.3815 5.24518L5.88173 9.74554Z"
                                fill="#fff" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M0 7C0 3.13409 3.13409 0 7 0C10.8659 0 14 3.13409 14 7C14 10.8659 10.8659 14 7 14C3.13409 14 0 10.8659 0 7ZM7 12.7273C6.24788 12.7273 5.50313 12.5791 4.80827 12.2913C4.1134 12.0035 3.48203 11.5816 2.95021 11.0498C2.41838 10.518 1.99651 9.8866 1.70869 9.19173C1.42087 8.49687 1.27273 7.75212 1.27273 7C1.27273 6.24788 1.42087 5.50313 1.70869 4.80827C1.99651 4.1134 2.41838 3.48203 2.95021 2.95021C3.48203 2.41838 4.1134 1.99651 4.80827 1.70869C5.50313 1.42087 6.24788 1.27273 7 1.27273C8.51897 1.27273 9.97572 1.87613 11.0498 2.95021C12.1239 4.02428 12.7273 5.48103 12.7273 7C12.7273 8.51897 12.1239 9.97572 11.0498 11.0498C9.97572 12.1239 8.51897 12.7273 7 12.7273Z"
                                fill="#fff" />
                        </svg>
                        Dilamar</span>
                    <div class="mt-2">
                        @if(\Carbon\Carbon::now()->subDays(1) > $value->lamaran->tanggal_akhir)
                        <p class="text-secondary m-0">Lowongan sudah tutup</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    {{-- <table id="datatable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Akhir</th>
                <th>Logo</th>
                <th>Perusahaan</th>
                <th>Jabatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="listlamaran">
            @foreach($lamaran as $key => $value)
            <tr>
                <td>{{$key+1}}</td>
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
    </table> --}}
    <h3 class="mt-5">Daftar Lowongan Kerja</h3>
    <div class="card">
        <div class="card-body">
            <div class="">
                <table id="datatable3" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Akhir</th>
                            <th>Logo</th>
                            <th>Perusahaan</th>
                            <th>Jabatan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="listloker">
                        @foreach($loker as $key => $value)
                        <tr>
                            <td>{{$key+1}}</td>
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
                                    <button class="button button-mini button-border button-circle button-yellow"
                                        id="btnkirimloker" onclick="kirimloker({{$value->id}})">Kirim
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
    function kirimloker(id) {
        Swal.fire({
            background:'#0069d900',
            color: "#e1e1e1",
            width: 600,
            html:'',
            showConfirmButton: false,
            allowOutsideClick: false,
            showClass: {
                popup: `
                    animated
                    fadeInUp
                    faster
                `
            },
            backdrop: `
                rgba(0,0,0,0)
                url("/GambarV2/menunggu.gif")
                center
                no-repeat
            `,
        })
        setTimeout(() => {
            $.ajax({
                method: 'POST',
                url: '/loker/apply',
                data: {
                    class_id : id,
                },
                beforeSend: function() {
                    // 
                },
                success: function(data) {
                    let html = '';
                    let html2 = '';
                    setTimeout(() => {
                        if (!data.success) {
                            Swal.fire({
                                title:'Info',
                                text:data.message,
                                icon:'info',
                                showConfirmButton: false,
                            });
                            return false;
                        }
                        let no = 1;
                        let no2 = 1;
                        data.data.lamaran.forEach(v => {
                            html += '<tr>';
                            html += '<td>'+no+'</td>';
                            html += '<td>'+dayjs(v.lamaran.tanggal_akhir).format('DD-MM-YYYY')+'</td>';
                            html += '<td>';
                                let image = '';
                                if (v.lamaran.perusahaan) {
                                    let js = JSON.parse(v.lamaran.perusahaan.image)
                                    image = js?js.url:'';
                                }else{
                                    image = v.lamaran.image?JSON.parse(v.lamaran.image).url:'';
                                }
                                html += '    <img src="/image/loker/'+image+'" alt="" style="" width="70px"';
                                html += '        height="30px">';
                            html += '</td>';
                            let nama = v.lamaran.nama;
                            if (v.lamaran.perusahaan) {
                                nama = v.lamaran.perusahaan.nama;
                            }
                            html += '<td>'+nama+'</td>';
                            html += '<td>'+v.lamaran.title+'</td>';
                            html += '<td>';
                            html += '        <a href="/loker/'+v.lamaran.id+'/detail">';
                            html += '            <button';
                            html += '                class="button button-mini button-border button-circle button-aqua">Detail</button>';
                            html += '        </a>';
                            html += '</td>';
                            html += '</tr>';
                            no++;
                        });
                        data.data.loker.forEach(va => {
                            html2+='<tr>';
                            html2+='    <td>'+no2+'</td>';
                            html2+='    <td>'+dayjs(va.tanggal_akhir).format('DD-MM-YYYY')+'</td>';
                            html2 += '<td>';
                                let image = '';
                                if (va.perusahaan) {
                                    let js = JSON.parse(va.perusahaan.image)
                                    image = js?js.url:'';
                                }else{
                                    image = va.image?JSON.parse(va.image).url:'';
                                }
                                html2 += '    <img src="/image/loker/'+image+'" alt="" style="" width="70px"';
                                html2 += '        height="30px">';
                            html2 += '</td>';
                            let nama = va.nama;
                            if (va.perusahaan) {
                                nama = va.perusahaan.nama;
                            }
                            html2 += '<td>'+nama+'</td>';
                            html2+='    <td>';
                            html2+='        <div class="row">';
                            html2+='            <button class="button button-mini button-border button-circle button-yellow"';
                            html2+='                id="btnkirimloker" onclick="kirimloker('+va.id+')">Kirim';
                            html2+='                Lamaran</button>';
                            html2+='            <a href="/loker/'+va.id+'/detail">';
                            html2+='                <button';
                            html2+='                    class="button button-mini button-border button-circle button-aqua">Detail</button>';
                            html2+='            </a>';
                            html2+='        </div>';
                            html2+='    </td>';
                            html2+='</tr>';
                            no2++;
                        });

                        Swal.fire({
                            background:'#0069d900',
                            color: "#e1e1e1",
                            width: 600,
                            html:'',
                            showConfirmButton: false,
                            allowOutsideClick: true,
                            showClass: {
                                popup: `
                                    animated
                                    fadeInUp
                                    faster
                                `
                            },
                            backdrop: `
                                rgba(0,0,0,0)
                                url("/GambarV2/success.gif")
                                center
                                no-repeat
                            `,
                        })
                        $('#listlamaran').html(html);
                        $('#listloker').html(html2);
                    }, 100);
                },
                error: function(xhr) { // if error occured
                    alert("Error occured.please try again");
                    Swal.close()
                },
                complete: function() {
                    console.log('complete');
                    Swal.close()
                },
            });
        }, 1000);
    }
</script>