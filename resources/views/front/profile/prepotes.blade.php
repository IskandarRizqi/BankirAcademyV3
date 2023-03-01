<div class="table-responsive">
    <table id="ppt" class="table table-bordered">
        <thead>
            <tr class="text-center">
                <th>No</th>
                <th>Kelas</th>
                <th>Nilai</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($prepotes as $key => $v)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{json_decode($v->kelas_id)->title}}</td>
                    <td>{{$v->nilai?$v->nilai:'Belum Diisi'}}</td>
                    <td>{{$v->nilai?'Sudah Diisi':'Belum Diisi'}}</td>
                    <td><button class="btn btn-info btn-sm" onclick="btnanswer({{$v}})" {{$v->nilai?'disabled':''}}><i class="icon-edit"></i></button></td>
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
    function btnanswer(data) {
        $('#pertanyaanModal').modal('show');
        $('#test').html(null);
        let pty = JSON.parse(data.pertanyaan);
        let jwb = JSON.parse(data.jawaban);
        console.log(data);
        let h = '';
        h+='<input type="text" name="id" value="'+data.id+'" hidden>';
        h+='<input type="text" name="classid" value="'+data.class_id+'" hidden>';
        h+='<textarea name="jwb" hidden>'+data.jawaban+'</textarea>';
        for (let index = 0; index < pty.length; index++) {
            const el = pty[index];
            h+='<h5>'+(index+1)+'. '+el+'</h5>';
            h+='<select name="jawaban['+index+']" class="form-control">';
            h+='    <option value="A">'+jwb.answerA[index]+'</option>';
            h+='    <option value="B">'+jwb.answerB[index]+'</option>';
            h+='    <option value="C">'+jwb.answerC[index]+'</option>';
            h+='    <option value="D">'+jwb.answerD[index]+'</option>';
            h+='</select>';
        }
        $('#test').html(h);
    }
</script>