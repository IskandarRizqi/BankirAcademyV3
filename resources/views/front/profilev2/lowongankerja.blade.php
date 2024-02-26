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
        <tbody id="listlamaran">
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
                            html += '<td>';
                                let image = '';
                                if (va.lamaran.perusahaan) {
                                    let js = JSON.parse(va.lamaran.perusahaan.image)
                                    image = js?js.url:'';
                                }else{
                                    image = va.lamaran.image?JSON.parse(va.lamaran.image).url:'';
                                }
                                html += '    <img src="/image/loker/'+image+'" alt="" style="" width="70px"';
                                html += '        height="30px">';
                            html += '</td>';
                            let nama = va.lamaran.nama;
                            if (va.lamaran.perusahaan) {
                                nama = va.lamaran.perusahaan.nama;
                            }
                            html += '<td>'+nama+'</td>';
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