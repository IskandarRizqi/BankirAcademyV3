<style>
    .progress {
    position: relative;
	height: 25px;
}
.progress > .progress-type {
	position: absolute;
	left: 0px;
	font-weight: 800;
	padding: 3px 30px 2px 10px;
	color: rgb(255, 255, 255);
	background-color: rgba(25, 25, 25, 0.2);
}
.progress > .progress-completed {
	position: absolute;
	right: 0px;
	font-weight: 800;
	padding: 13px 10px 2px;
}
</style>
<div class="table-responsive">
    <table id="ppt" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kelas</th>
                <th>Nilai Pre</th>
                <th>Nilai Pos</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prepotes as $key => $v)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{json_decode($v->kelas_id)->title}}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{$v->nilai_awal}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$v->nilai_awal}}%" title="{{$v->nilai_awal}}">
                            </div>
                            <span class="progress-completed">{{$v->nilai_awal}}</span>
                        </div>
                    </td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{$v->nilai_akhir}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$v->nilai_akhir}}%" title="{{$v->nilai_akhir}}">
                            </div>
                            <span class="progress-completed">{{$v->nilai_akhir}}</span>
                        </div>
                    </td>
                    <td>{{$v->nilai_awal>=0?'Sudah Diisi':'Belum Diisi'}}</td>
                    <td>
                        <button class="btn btn-info btn-sm" onclick="btnanswer({{$v}})" title="Isi"><i class="icon-edit"></i></button>
                        <button class="btn btn-info btn-sm" onclick="cetakanswer({{$v}})" {{$v->nilai?'disabled':''}} title="Cetak"><i class="icon-print"></i></button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Participant-->
<div class="modal fade" id="pertanyaanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/prepotes/savejawaban" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h3>Pertanyaan</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="test">
                    {{--  --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnpertanyaan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#ppt').dataTable();
    })
    function cetakanswer(params) {
        console.log(params);
    }
    function btnanswer(data) {
        $('#pertanyaanModal').modal('show');
        $('#test').html(null);
        let pty = JSON.parse(data.pertanyaan);
        let jwb = JSON.parse(data.jawaban);
        let awal = 0;
        if (data.nilai_awal) {
            awal = data.nilai_awal;
        }
        console.log(data);
        let h = '';
        h+='<input type="text" name="id" value="'+data.id+'" hidden>';
        h+='<input type="text" name="nilai_awal" value="'+awal+'" hidden>';
        h+='<input type="text" name="classid" value="'+data.class_id+'" hidden>';
        h+='<textarea name="jwb" hidden>'+data.jawaban+'</textarea>';
        for (let index = 0; index < pty.length; index++) {
            const el = pty[index];
            h+='<h5 class="mt-2" style="margin-bottom:0px">'+(index+1)+'. '+el+'</h5>';
            // h+='<select name="jawaban['+index+']" class="form-control">';
            // h+='    <option value="A">'+jwb.answerA[index]+'</option>';
            // h+='    <option value="B">'+jwb.answerB[index]+'</option>';
            // h+='    <option value="C">'+jwb.answerC[index]+'</option>';
            // h+='    <option value="D">'+jwb.answerD[index]+'</option>';
            // h+='</select>';
            h+='<div class="form-check">'
            h+='    <input class="form-check-input" type="radio" value="A" name="jawaban['+index+']">'
            h+='    <label class="form-check-label" for="flexRadioDefault1">'
            h+='        '+jwb.answerA[index]+''
            h+='    </label>'
            h+='</div>'
            h+='<div class="form-check">'
            h+='    <input class="form-check-input" type="radio" value="B" name="jawaban['+index+']">'
            h+='    <label class="form-check-label" for="flexRadioDefault1">'
            h+='        '+jwb.answerB[index]+''
            h+='    </label>'
            h+='</div>'
            h+='<div class="form-check">'
            h+='    <input class="form-check-input" type="radio" value="C" name="jawaban['+index+']">'
            h+='    <label class="form-check-label" for="flexRadioDefault1">'
            h+='        '+jwb.answerC[index]+''
            h+='    </label>'
            h+='</div>'
            h+='<div class="form-check">'
            h+='    <input class="form-check-input" type="radio" value="D" name="jawaban['+index+']">'
            h+='    <label class="form-check-label" for="flexRadioDefault1">'
            h+='        '+jwb.answerD[index]+''
            h+='    </label>'
            h+='</div>'
        }
        $('#test').html(h);
    }
</script>