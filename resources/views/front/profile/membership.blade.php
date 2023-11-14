<h3 class="text-center text-uppercase">Membership</h3>
<div class="title-block">
    <div class="row">
        @if($ismember == 1)
        <div class="col-lg-12">
            <img src="{{asset('front/images/A_MEMBER.jpg')}}" alt="">
            <div class="caption text-center" style="font-size: 2vw"><b>Masa Aktif :
                    {{\Carbon\Carbon::parse($user->profile->masa_aktif_membership)->format('d-m-Y')}}</b></div>
        </div>
        @elseif($ismember == 2)
        <div class="col-lg-12">
            <img src="{{asset('front/images/A_PROSES_MEMBER.jpg')}}" alt="">
            <div class="caption text-center text-capitalize" style="font-size: 2vw"><b>permohonan anda sedang
                    di</b></div>
        </div>
        @else
        <div class="col-lg-12">
            <img src="{{asset('front/images/A_BLM_MEMBER.jpg')}}" alt="">
            <div class="caption text-center" style="font-size: 2vw">
            </div>
        </div>
        <div class="col-lg-12 layout-spacing align-middle">
            <div class="row justify-content-center">
                @foreach($member as $key => $v)
                <div style="overflow: auto">
                    <div class="col-md-3">
                        <div class="captionmember">{!!$v->keterangan!!}</div>
                        <img src="{{asset($v->gambar)}}" onclick="openmember({{$v}})" alt="" style="cursor: pointer">
                        <div class="">
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
<div class="modal" tabindex="-1" id="modalmember">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Membership</h5>
                <button type="button" class="" data-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <form action="/updatemember" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="user_id" id="user_id" value="{{ Auth::user()->id }}" hidden>
                    <input type="text" name="status_membership" id="status_membership" value="2" hidden>
                    <input type="text" name="id_member" id="id_member" hidden>
                    <div id="detailmember"></div>
                    <div class="col-lg-12">
                        <label for="form-control">Bukti Pembayaran</label>
                        <input type="file" class="form-control" name="image_bukti_pembayaran"
                            id="image_bukti_pembayaran" accept="image/png, image/jpeg">
                        <img id="pctrbuktipembayaran" src="" alt="" width="500px">
                        @error('image_bukti_pembayaran')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                        <button class="btn btn-primary mt-2">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function openmember(val) {
        $('#id_member').val(val['id']);
        let p = '<h3>Harga Member : <strong>'+val.harga.toLocaleString()+'</strong></h3>';
        p+='<span>No. Rekening : 8035559091</span><br>';
        p+='<span>Atas Nama : PT. Bankir Academy Indonesia</span>';
        $('#detailmember').html(p);
        $('#modalmember').modal('show');
    }
</script>