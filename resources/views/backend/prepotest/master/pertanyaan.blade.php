@extends('backend.template')
@section('content')
<!-- Button trigger modal -->
<div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="pills-home-tab" data-toggle="pill" data-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true" style="border-color: #007bff">Pertanyaan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-profile-tab" data-toggle="pill" data-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false" style="border-color: #007bff">List</button>
        </li>
        {{-- <li class="nav-item" role="presentation">
            <button class="nav-link" id="pills-contact-tab" data-toggle="pill" data-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</button>
        </li> --}}
    </ul>
    <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            
    <div class="widget-content widget-content-area br-6">
        <button type="button" class="btn btn-primary btn-sm m-2" data-toggle="modal" data-target="#partnerModal" onclick="edit(null)">
            Tambah
        </button>
        <table id="zero-config" class="table dt-table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Kelas</th>
                    <th>Pertanyaan</th>
                    <th class="no-content">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr>
                        <td>{{json_decode($value->kelas_id)->title}}</td>
                        <td>
                            @foreach(json_decode($value->pertanyaan) as $key => $v)
                            <span class="badge badge-info">{{$v}}</span>
                            @endforeach
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning btn-sm m-2" data-toggle="modal" data-target="#partnerModal" onclick="edit({{$value}})">
                            <i class="bx bx-pencil"></i>
                        </button>
                        <button type="button" class="btn btn-danger btn-sm m-2" onclick="hapus('{{$value->id}}')">
                            <i class="bx bx-trash"></i>
                        </button>
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="widget-content widget-content-area br-6">
            <table id="one-config" class="table dt-table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Pertanyaan</th>
                        <th>User</th>
                        <th>Nilai</th>
                        <th class="no-content">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prepotes as $key => $value)
                        <tr>
                            <td>{{json_decode($value->kelas_id)->title}}</td>
                            <td>
                                @foreach(json_decode($value->pertanyaan) as $key => $v)
                                <span class="badge badge-info">{{$v}}</span>
                                @endforeach
                            </td>
                            <td>{{$value->name}}</td>
                            <td>{{$value->nilai}}</td>
                            <td>
                                <button type="button" class="btn btn-warning btn-sm m-2" data-toggle="modal" data-target="#partnerModal" onclick="editlist({{$value}})">
                                <i class="bx bx-pencil"></i>
                            </button>
                            {{-- <button type="button" class="btn btn-danger btn-sm m-2" onclick="hapus('{{$value->id}}')">
                                <i class="bx bx-trash"></i>
                            </button> --}}
                        </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </div>
        {{-- <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...</div> --}}
      </div>
</div>
<!-- Modal -->
<div class="modal fade" id="partnerModal" tabindex="-1" aria-labelledby="partnerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="/admin/prepotes" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <input type="text" name="id" id="id" hidden>
                    <div class="form-group">
                        <label for="">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control">
                            <option value="">Pilih Kelas</option>
                            @foreach($kelas as $key => $value)
                                <option value="{{json_encode($value)}}">{{$value->title}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="after-add-more">
                    </div>
                    <button class="btn btn-success add-more" type="button">
                        <i class="glyphicon glyphicon-plus"></i> Add
                    </button>
                </div>
                <div class="modal-footer">
                    <span class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</span>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
            <form id="form_delete" action="" method="post">
                @csrf
                @method('delete')
                <input type="text" name="id_partner" id="id_partner" hidden>
            </form>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script>
    // var firstUpload = new FileUploadWithPreview('myFirstImage')
    let no=1;
    createDataTable('#zero-config')
    createDataTable('#one-config')
    $(document).ready(function() {
        $(".add-more").click(function(){
            var n = document.getElementsByClassName("tanya").length;
            if (n > 14) {
                return Swal.fire('Info','Maksimal Pertanyaan 15')
            }
            var html = '';
            html+='<div class="row" id="form'+no+'">';
            html+='<div class="mt-2 col-lg-9">';
            html+='    <label for="">Pertanyaan</label>';
            html+='    <input type="text" name="ask[]" class="form-control tanya" required>';
            html+='</div>';
            html+='<div class="mt-2 col-lg-3">';
            html+='    <label for="">Jwb. Benar</label>';
            html+='<select name="benar[]" id="benar" class="form-control">';
            html+='    <option value="A">A</option>';
            html+='    <option value="B">B</option>';
            html+='    <option value="C">C</option>';
            html+='    <option value="D">D</option>';
            html+='    <option value="E">E</option>';
            html+='</select>';
            html+='</div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban A</label><input type="radio" name="benar'+no+'" title="Benar" value="A" hidden></div>';
            html+='        <input type="text" name="answerA[]" class="form-control">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban B</label><input type="radio" name="benar'+no+'" title="Benar" value="B" hidden></div>';
            html+='        <input type="text" name="answerB[]" class="form-control">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban C</label><input type="radio" name="benar'+no+'" title="Benar" value="C" hidden></div>';
            html+='        <input type="text" name="answerC[]" class="form-control">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban D</label><input type="radio" name="benar'+no+'" title="Benar" value="D" hidden></div>';
            html+='        <input type="text" name="answerD[]" class="form-control">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban E</label><input type="radio" name="benar'+no+'" title="Benar" value="E" hidden></div>';
            html+='        <input type="text" name="answerE[]" class="form-control">';
            html+='    </div>';
            html+='    <span class="btn-sm btn_remove" id='+no+' type="button" title="remove">x</span>';
            html+='</div>';
            $(".after-add-more").append(html);
            no++;
        });
    
        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#form'+button_id+'').remove();  
        });  
    });
    function edit(data) {
        // console.log(data);
        $(".after-add-more").html(null);
        if (!data) {
                $('#id').val(null);
                $('#kelas').val(null);
                $('#kelas').trigger('change');
                return
            }
        var html = '';
        var i = 0;
        $('#id').val(data.id);
        var selId = document.getElementById("kelas");
        var items = selId.options;//Javascript get select all option
        // console.log(items[1].value);
        // console.log(data.kelas_id);

        for (var i = 0; i < items.length; i++) {
            if (items[i].value.id == data.kelas_id.id) {
                    items[i].selected = true;
            }
        }
        let jwb = JSON.parse(data.jawaban);
        let prt = JSON.parse(data.pertanyaan);
        for (let index = 0; index < prt.length; index++) {
            var kosong = '';
            html+='<div class="row" id="form'+index+'">';
            html+='<div class="mt-2 col-lg-9">';
            html+='    <label for="">Pertanyaan</label>';
            html+='    <input type="text" name="ask[]" class="form-control tanya" value="'+prt[index]+'" required>';
            html+='</div>';
            html+='<div class="mt-2 col-lg-3">';
            html+='    <label for="">Jwb. Benar</label>';
            html+='<select name="benar[]" id="benar" class="form-control">';
                if (jwb.benar[index]=="A") { 
                    html+='    <option value="A" selected>A</option>';
                }else{
                    html+='    <option value="A">A</option>';
                }
                if (jwb.benar[index]=="B") { 
                    html+='    <option value="B" selected>B</option>';
                }else{
                    html+='    <option value="B">B</option>';
                }
                if (jwb.benar[index]=="C") { 
                    html+='    <option value="C" selected>C</option>';
                }else{
                    html+='    <option value="C">C</option>';
                }
                if (jwb.benar[index]=="D") { 
                    html+='    <option value="D" selected>D</option>';
                }else{
                    html+='    <option value="D">D</option>';
                }
                if (jwb.benar[index]=="E") { 
                    html+='    <option value="E" selected>E</option>';
                }else{
                    html+='    <option value="E">E</option>';
                }
            html+='</select>';
            html+='</div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban A</label><input type="radio" name="benar'+index+'" value="A" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerA[]" class="form-control" value="'+jwb.answerA[index]+'">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban B</label><input type="radio" name="benar'+index+'" value="B" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerB[]" class="form-control" value="'+jwb.answerB[index]+'">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban C</label><input type="radio" name="benar'+index+'" value="C" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerC[]" class="form-control" value="'+jwb.answerC[index]+'">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban D</label><input type="radio" name="benar'+index+'" value="D" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerD[]" class="form-control" value="'+jwb.answerD[index]+'">';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban E</label><input type="radio" name="benar'+index+'" value="E" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerE[]" class="form-control" value="'+jwb.answerE[index]+'">';
            html+='    </div>';
            html+='    <span class="btn-sm btn_remove" id='+index+' type="button" title="remove">x</span>';
            html+='</div>';
        }
        $(".after-add-more").append(html);
        no = prt.length;
    }
    function editlist(data) {
        $(".after-add-more").html(null);
        if (!data) {
                $('#id').val(null);
                $('#kelas').val(null);
                $('#kelas').trigger('change');
                return
            }
        var html = '';
        var i = 0;
        var selId = document.getElementById("kelas");
        var items = selId.options;//Javascript get select all option
        
        for (var i = 0; i < items.length; i++) {
            if (items[i].value.id == data.kelas_id.id) {
                    items[i].selected = true;
            }
        }
        let usr = JSON.parse(data.jwbuser);
        let jwb = JSON.parse(data.jawaban);
        let prt = JSON.parse(data.pertanyaan);
        // console.log(usr);
        // console.log(jwb);
        for (let index = 0; index < prt.length; index++) {
            var kosong = '';
            html+='<div class="row" id="form'+index+'">';
            html+='<div class="mt-2 col-lg-9">';
            html+='    <label for="">Pertanyaan</label>';
            html+='    <input type="text" name="ask[]" class="form-control tanya" value="'+prt[index]+'" required readonly>';
            html+='</div>';
            html+='<div class="mt-2 col-lg-3">';
            html+='    <label for="">Jwb. User</label>';
            html+='<select name="benar[]" id="benar" class="form-control" disabled>';
                if (usr[index]=="A") { 
                    html+='    <option value="A" selected>A</option>';
                }else{
                    html+='    <option value="A">A</option>';
                }
                if (usr[index]=="B") { 
                    html+='    <option value="B" selected>B</option>';
                }else{
                    html+='    <option value="B">B</option>';
                }
                if (usr[index]=="C") { 
                    html+='    <option value="C" selected>C</option>';
                }else{
                    html+='    <option value="C">C</option>';
                }
                if (usr[index]=="D") { 
                    html+='    <option value="D" selected>D</option>';
                }else{
                    html+='    <option value="D">D</option>';
                }
                if (usr[index]=="E") { 
                    html+='    <option value="E" selected>E</option>';
                }else{
                    html+='    <option value="E">E</option>';
                }
            html+='</select>';
            html+='</div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban A</label><input type="radio" name="benar'+index+'" value="A" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerA[]" class="form-control" value="'+jwb.answerA[index]+'" readonly>';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban B</label><input type="radio" name="benar'+index+'" value="B" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerB[]" class="form-control" value="'+jwb.answerB[index]+'" readonly>';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban C</label><input type="radio" name="benar'+index+'" value="C" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerC[]" class="form-control" value="'+jwb.answerC[index]+'" readonly>';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban D</label><input type="radio" name="benar'+index+'" value="D" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerD[]" class="form-control" value="'+jwb.answerD[index]+'" readonly>';
            html+='    </div>';
            html+='    <div class="form-group col-lg-3 ">';
            html+='        <div class="d-flex"><label for="" class="mr-auto">Jawaban D</label><input type="radio" name="benar'+index+'" value="E" title="Benar" hidden></div>';
            html+='        <input type="text" name="answerE[]" class="form-control" value="'+jwb.answerE[index]+'" readonly>';
            html+='    </div>';
            html+='    <span class="btn-sm btn_remove" id='+index+' type="button" title="remove">x</span>';
            html+='</div>';
        }
        $(".after-add-more").append(html);
    }
    // $('#kelas').on('change',function () {
    //     let v = $('#kelas').val();
    //     if (v) {
    //     let val = JSON.parse(v);
    //         return console.log(val);
    //     }
    //     // return console.log('val');
    // })
    function chooseOption(n) {
        for (let index = 1; index < 6; index++) {
            if (index==n) {
                // $(this).parents("#answer"+n).removeAttr('hidden');
                $('#answer'+n).removeAttr('hidden');
            }else{
                // $(this).parents("#answer"+n).attr('hidden',true);
                $('#answer'+index).attr('hidden',true);
            }
        }
    }
    function hapus(id) {
        $('#id_partner').val(id)
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            padding: '2em'
        }).then(function(result) {
            if (result.value) {
                $('#form_delete').attr('action','/admin/prepotes/'+id)
                $('#form_delete').submit()
            }
        });
    }

</script>
@endsection